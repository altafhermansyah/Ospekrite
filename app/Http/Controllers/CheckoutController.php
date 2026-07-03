<?php

namespace App\Http\Controllers;

use App\Actions\CreateOrderAction;
use App\DTOs\CheckoutDTO;
use App\Exceptions\DuplicateCheckoutException;
use App\Exceptions\InsufficientStockException;
use App\Http\Requests\CheckoutRequest;
use App\Services\CartService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService       $cartService,
        protected CreateOrderAction $createOrderAction,
    ) {}

    /**
     * GET /checkout
     * Display the checkout form.
     * Guard: redirect home if cart is empty.
     */
    public function index()
    {
        $cart = $this->cartService->getCart();

        if (empty($cart['items'])) {
            return redirect()->route('home')
                ->with('error', 'Keranjangmu masih kosong.');
        }

        return view('checkout.index', [
            'cart'           => $cart,
            'cartCount'      => $this->cartService->getCount(),
            'fakultasList'   => config('ospekrite.fakultas_list', []),
            'idempotencyKey' => Str::uuid()->toString(),
        ]);
    }

    /**
     * POST /checkout
     * Validate, create order, clear cart, redirect to payment page.
     * Rate-limited to 5 req/min/IP via route middleware.
     */
    public function store(CheckoutRequest $request)
    {
        $dto = CheckoutDTO::fromArray($request->validated());

        try {
            $order = $this->createOrderAction->execute($dto);

            // STEP 9 — Clear cart after successful transaction commit.
            // Deliberately outside DB::transaction() so session/cookie state
            // is not entangled in the database rollback scope.
            $this->cartService->clear();

            // STEP 10 — Redirect to payment page.
            if ($order->payment_type->value === \App\Enums\PaymentType::QrisDinamis->value) {
                $paymentService = app(\App\Contracts\PaymentServiceInterface::class);
                $transaction = $paymentService->createTransaction($order);
                return redirect($transaction['redirect_url']);
            }

            return redirect()->route('pembayaran.index', $order->no_invoice)
                ->with('success', 'Pesanan berhasil dibuat! Selesaikan pembayaranmu.');

        } catch (DuplicateCheckoutException $e) {
            // Idempotency: user double-clicked or retried — silently redirect
            // them to the existing order instead of showing an error.
            Log::warning('Duplicate checkout caught in controller', [
                'idempotency_key' => $dto->idempotency_key,
                'no_invoice'      => $e->getOrder()->no_invoice,
            ]);

            return redirect()->route('pembayaran.index', $e->getOrder()->no_invoice)
                ->with('info', 'Pesananmu sudah ada. Silakan selesaikan pembayaran.');

        } catch (InsufficientStockException $e) {
            return redirect()->route('checkout.index')
                ->withInput()
                ->with('error_stock', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Checkout failed', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return redirect()->route('checkout.index')
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba beberapa saat lagi.');
        }
    }
}
