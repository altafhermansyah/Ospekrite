<?php

namespace App\Actions;

use App\DTOs\CheckoutDTO;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Exceptions\DuplicateCheckoutException;
use App\Exceptions\InsufficientStockException;
use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProdukVarian;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * CreateOrderAction
 *
 * Mission-critical action class.  All database mutations are wrapped in a
 * single DB::transaction().  Row-level locks (lockForUpdate) are applied to
 * every produk_varian row before stock is checked, preventing race conditions
 * when two users check out the same product simultaneously.
 *
 * This class NEVER touches the session or cookies — that responsibility
 * belongs to CartService and is called from CheckoutController after a
 * successful order creation.
 *
 * Execution flow (mirrors AI_CONTEXT Steps 1-10):
 *  1. Idempotency check
 *  2. Re-resolve cart from DB (via OrderService)
 *  3. lockForUpdate() + stock validation per item
 *  4. Server-side total calculation
 *  5. Insert order row
 *  6. Generate & persist invoice number
 *  7. Insert order_item rows (with JSON snapshot)
 *  8. Stock NOT deducted (QRIS Statis — deducted by admin on payment confirm)
 *  9. Cart cleared by caller (CheckoutController)
 * 10. Return the committed Order model
 */
class CreateOrderAction
{
    public function __construct(
        private readonly CartService  $cartService,
        private readonly OrderService $orderService,
    ) {}

    /**
     * @throws DuplicateCheckoutException
     * @throws InsufficientStockException
     * @throws \Exception
     */
    public function execute(CheckoutDTO $dto): Order
    {
        // Pull session items before the transaction (outside lock scope).
        $sessionCart  = $this->cartService->getCart();
        $sessionItems = $sessionCart['items'] ?? [];

        if (empty($sessionItems)) {
            throw new \Exception('Keranjang kosong. Tidak bisa membuat pesanan.');
        }

        // Pre-resolve DB records outside the transaction for query efficiency.
        // The real stock check with locks happens inside the transaction below.
        $resolvedItems = $this->orderService->resolveCartItems($sessionItems);

        return DB::transaction(function () use ($dto, $resolvedItems) {

            // ---------------------------------------------------------------
            // STEP 1 — Idempotency check
            // ---------------------------------------------------------------
            $existing = Order::where('idempotency_key', $dto->idempotency_key)->first();

            if ($existing) {
                Log::info('Duplicate checkout attempt', [
                    'idempotency_key' => $dto->idempotency_key,
                    'existing_order'  => $existing->no_invoice,
                ]);
                throw new DuplicateCheckoutException($existing);
            }

            // ---------------------------------------------------------------
            // STEP 2 & 3 — Lock rows and validate stock for every item
            // ---------------------------------------------------------------
            $verifiedItems = [];

            foreach ($resolvedItems as $key => $item) {
                if ($item['tipe'] === 'produk') {
                    // Lock the specific variant row to prevent concurrent deductions.
                    /** @var ProdukVarian $varian */
                    $varian = ProdukVarian::with('produk')
                        ->where('id_varian', $item['id_ref'])
                        ->lockForUpdate()
                        ->first();

                    if (!$varian || !$varian->produk) {
                        throw new \Exception(
                            "Produk varian ID {$item['id_ref']} tidak ditemukan saat memproses pesanan."
                        );
                    }

                    if ($varian->stok < $item['qty']) {
                        throw new InsufficientStockException(
                            "Stok \"{$varian->produk->nama_produk} — {$varian->nama_varian}\" tidak mencukupi. " .
                            "Diminta: {$item['qty']}, Tersedia: {$varian->stok}.",
                            itemName:  "{$varian->produk->nama_produk} — {$varian->nama_varian}",
                            requested: $item['qty'],
                            available: $varian->stok,
                        );
                    }

                    // Re-read price from DB after lock, overwrite pre-resolved price.
                    $verifiedItems[$key] = array_merge($item, [
                        'db_harga'    => $varian->produk->harga_dasar + $varian->harga_tambahan,
                        'db_stok'     => $varian->stok,
                        'nama_produk' => $varian->produk->nama_produk,
                        'nama_varian' => $varian->nama_varian,
                        'id_varian'   => $varian->id_varian,
                        'id_bundle'   => null,
                    ]);

                } elseif ($item['tipe'] === 'bundle') {
                    // For bundles: lock and validate every component variant.
                    $bundle = Bundle::with(['bundleItems.produk'])->find($item['id_ref']);

                    if (!$bundle) {
                        throw new \Exception("Bundle ID {$item['id_ref']} tidak ditemukan.");
                    }

                    /** @var BundleItem $bundleItem */
                    foreach ($bundle->bundleItems as $bundleItem) {
                        // Lock all variants of this component product.
                        $variantsTotalStock = ProdukVarian::where('id_produk', $bundleItem->id_produk)
                            ->lockForUpdate()
                            ->sum('stok');

                        $requiredStock = $bundleItem->qty * $item['qty'];

                        if ($variantsTotalStock < $requiredStock) {
                            throw new InsufficientStockException(
                                "Stok komponen \"{$bundleItem->produk->nama_produk}\" dalam bundle tidak mencukupi. " .
                                "Dibutuhkan: {$requiredStock}, Tersedia: {$variantsTotalStock}.",
                                itemName:  $bundleItem->produk->nama_produk,
                                requested: $requiredStock,
                                available: (int) $variantsTotalStock,
                            );
                        }
                    }

                    $verifiedItems[$key] = array_merge($item, [
                        'db_harga'    => (float) $bundle->harga_bundle,
                        'nama_produk' => $bundle->nama_bundle,
                        'nama_varian' => null,
                        'id_varian'   => null,
                        'id_bundle'   => $bundle->id_bundle,
                    ]);
                }
            }

            // ---------------------------------------------------------------
            // STEP 4 — Calculate total from verified DB prices only
            // ---------------------------------------------------------------
            $totalTagihan = 0;
            foreach ($verifiedItems as $item) {
                $totalTagihan += (int) round($item['db_harga'] * $item['qty']);
            }

            // ---------------------------------------------------------------
            // STEP 5 — Insert the order row
            // ---------------------------------------------------------------
            $order = Order::create([
                'id_user'         => null,   // Guest checkout — no user account
                'no_invoice'      => null,   // Set after insert (Step 6)
                'nama_pembeli'    => $dto->nama_pembeli,
                'nim'             => $dto->nim,
                'no_whatsapp'     => $dto->no_whatsapp,
                'fakultas'        => $dto->fakultas,
                'email'           => $dto->email,
                'catatan'         => $dto->catatan,
                'total_tagihan'   => $totalTagihan,
                'status_order'    => OrderStatus::Pending->value,
                'status_payment'  => PaymentStatus::BelumBayar->value,
                'tanggal_order'   => Carbon::now(),
                'expired_at'      => Carbon::now()->addHours(
                    (int) config('ospekrite.payment_deadline_hours', 24)
                ),
                'payment_type'    => $dto->payment_type,
                'idempotency_key' => $dto->idempotency_key,
            ]);

            // ---------------------------------------------------------------
            // STEP 6 — Generate invoice number from committed id_order
            // Never use COUNT() — use the auto-incremented PK for uniqueness.
            // ---------------------------------------------------------------
            $year      = config('ospekrite.tahun', date('Y'));
            $prefix    = config('ospekrite.invoice_prefix', 'OSP');
            $noInvoice = $prefix . '-' . $year . '-' . str_pad($order->id_order, 6, '0', STR_PAD_LEFT);

            $order->update(['no_invoice' => $noInvoice]);
            $order->refresh();

            // ---------------------------------------------------------------
            // STEP 7 — Insert order_item rows with JSON snapshot
            // ---------------------------------------------------------------
            foreach ($verifiedItems as $item) {
                OrderItem::create([
                    'id_order'     => $order->id_order,
                    'id_varian'    => $item['id_varian'],
                    'id_bundle'    => $item['id_bundle'],
                    'qty'          => $item['qty'],
                    'harga_satuan' => (int) round($item['db_harga']),
                    // Snapshot of product/variant names at time of order —
                    // catalog data may change later; this preserves history.
                    'detail_varian' => [
                        'tipe'        => $item['tipe'],
                        'nama_produk' => $item['nama_produk'],
                        'nama_varian' => $item['nama_varian'],
                    ],
                ]);
            }

            // ---------------------------------------------------------------
            // STEP 8 — Stock is NOT deducted here.
            // QRIS Statis: deducted only after admin marks payment as 'lunas'.
            // QRIS Dinamis: deducted only after MockDynamicPaymentService SUCCESS.
            // Both paths will call a ReleaseStockAction (inverse) on cancel/expiry.
            // ---------------------------------------------------------------

            Log::info('Order created', [
                'id_order'  => $order->id_order,
                'no_invoice'=> $order->no_invoice,
                'total'     => $totalTagihan,
            ]);

            app(\App\Contracts\NotificationServiceInterface::class)->sendOrderCreated($order);

            return $order;

            // Transaction commits here. Cart is cleared by CheckoutController
            // after this method returns successfully.
        });
    }
}
