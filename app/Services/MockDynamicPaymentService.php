<?php

namespace App\Services;

use App\Contracts\PaymentServiceInterface;
use App\Models\Order;
use Illuminate\Support\Str;

/**
 * MockDynamicPaymentService
 *
 * Implements PaymentServiceInterface as a simulation layer for QRIS Dinamis.
 * No real payment gateway is contacted. Designed so that swapping to
 * MidtransPaymentService or XenditPaymentService requires ONLY changing
 * the binding in AppServiceProvider — zero controller changes.
 *
 * Simulated statuses: PENDING, SUCCESS, FAILED, EXPIRED, CANCELLED
 *
 * Stage 6B: this class is registered but not yet called from any controller.
 * When QRIS Dinamis is activated (future stage), the CheckoutController will
 * inject PaymentServiceInterface and call createTransaction().
 */
class MockDynamicPaymentService implements PaymentServiceInterface
{
    /**
     * Simulate creating a payment transaction.
     *
     * Returns a mock transaction payload resembling a real gateway response.
     * In production this would call Midtrans/Xendit and return their response.
     */
    public function createTransaction(Order $order): array
    {
        $transactionId = 'MOCK-' . strtoupper(Str::random(8)) . '-' . $order->id_order;
        $paymentUrl = route('mock.payment.page', ['invoice' => $order->no_invoice]);

        return [
            'transaction_id' => $transactionId,
            'order_id'       => $order->no_invoice,
            'amount'         => $order->total_tagihan,
            'status'         => self::STATUS_PENDING,
            'qr_code_url'    => null, 
            'redirect_url'   => $paymentUrl,
            'expired_at'     => now()->addDay()->toISOString(),
            'created_at'     => now()->toISOString(),
        ];
    }

    /**
     * Simulate fetching a transaction's payment status.
     *
     * In production this would call the gateway's status API.
     * Mock always returns 'PENDING' — real gateway returns live status.
     *
     * Possible values: PENDING, SUCCESS, FAILED, EXPIRED, CANCELLED
     */
    public function getStatus(string $transactionId): string
    {
        // Deterministic mock: transactions with ID ending in even digit return SUCCESS,
        // odd digit return PENDING. This allows basic integration testing without a gateway.
        $lastChar = substr($transactionId, -1);
        if (is_numeric($lastChar) && (int) $lastChar % 2 === 0) {
            return 'SUCCESS';
        }

        return 'PENDING';
    }

    /**
     * Simulate handling a payment gateway callback/webhook.
     *
     * In production this would:
     * 1. Verify the HMAC signature from the gateway
     * 2. Parse the payload
     * 3. Update the order status accordingly
     *
     * Mock implementation: no-op (logs the payload for debugging).
     */
    public function handleCallback(array $payload): void
    {
        $invoice = $payload['order_id'];
        $status = $payload['status'];
        $transactionId = $payload['transaction_id'];

        \Illuminate\Support\Facades\DB::transaction(function () use ($invoice, $status, $transactionId) {
            $order = Order::where('no_invoice', $invoice)->lockForUpdate()->first();
            if (!$order) return;

            // Idempotency: Prevent duplicate success callback from deducting stock twice
            if ($order->status_payment->value === \App\Enums\PaymentStatus::Lunas->value) {
                return;
            }

            if ($status === self::STATUS_SUCCESS) {
                $order->update([
                    'status_payment' => \App\Enums\PaymentStatus::Lunas,
                    'status_order' => \App\Enums\OrderStatus::Diproses,
                ]);

                // Deduct stock atomically
                foreach ($order->orderItems as $item) {
                    if ($item->id_varian) {
                        \App\Models\ProdukVarian::where('id_varian', $item->id_varian)
                            ->decrement('stok', $item->qty);
                    } elseif ($item->id_bundle) {
                        $bundle = \App\Models\Bundle::with('bundleItems')->find($item->id_bundle);
                        if ($bundle) {
                            foreach ($bundle->bundleItems as $bItem) {
                                \App\Models\ProdukVarian::where('id_produk', $bItem->id_produk)
                                    ->decrement('stok', $bItem->qty * $item->qty);
                            }
                        }
                    }
                }
                app(\App\Contracts\NotificationServiceInterface::class)->sendPaymentVerified($order);
            } elseif ($status === self::STATUS_FAILED || $status === self::STATUS_CANCELLED) {
                $order->update([
                    'status_payment' => \App\Enums\PaymentStatus::BelumBayar,
                ]);
                if ($status === self::STATUS_CANCELLED) {
                    app(\App\Contracts\NotificationServiceInterface::class)->sendOrderCancelled($order);
                }
            } elseif ($status === self::STATUS_EXPIRED) {
                $order->update([
                    'status_payment' => \App\Enums\PaymentStatus::Expired,
                    'status_order' => \App\Enums\OrderStatus::Batal,
                ]);
                app(\App\Actions\ReleaseStockAction::class)->execute($order);
                app(\App\Contracts\NotificationServiceInterface::class)->sendOrderExpired($order);
            }

            \Illuminate\Support\Facades\Log::info('Mock Transaction Status Changed', [
                'transaction_id' => $transactionId,
                'status' => $status,
                'timestamp' => now()->toISOString(),
            ]);
        });
    }
}
