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

        return [
            'transaction_id' => $transactionId,
            'order_id'       => $order->no_invoice,
            'amount'         => $order->total_tagihan,
            'status'         => 'PENDING',
            'qr_code_url'    => null, // Would be populated by real gateway
            'redirect_url'   => null, // Would be populated by real gateway
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
        \Illuminate\Support\Facades\Log::info('[MockDynamicPaymentService] Callback received (no-op)', [
            'payload' => $payload,
        ]);
        // No-op: real implementation would update Order and Pembayaran records here
    }
}
