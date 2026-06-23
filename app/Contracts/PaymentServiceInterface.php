<?php

namespace App\Contracts;

use App\Models\Order;

interface PaymentServiceInterface
{
    /**
     * Create a payment transaction for the given order.
     *
     * @return array Transaction data (id, redirect_url, etc.)
     */
    public function createTransaction(Order $order): array;

    /**
     * Get the current status of a payment transaction.
     */
    public function getStatus(string $transactionId): string;

    /**
     * Handle a callback/webhook from the payment gateway.
     */
    public function handleCallback(array $payload): void;
}
