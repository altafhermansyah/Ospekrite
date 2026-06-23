<?php

namespace App\Contracts;

use App\Models\Order;

interface NotificationServiceInterface
{
    /**
     * Called when a user successfully creates a new order.
     */
    public function sendOrderCreated(Order $order): void;

    /**
     * Called when a user uploads payment proof (QRIS Statis).
     */
    public function sendPaymentUploaded(Order $order): void;

    /**
     * Called when payment is successfully verified and marked as Lunas.
     */
    public function sendPaymentVerified(Order $order): void;

    /**
     * Called when an order is packed and ready for pickup.
     */
    public function sendOrderReady(Order $order): void;

    /**
     * Called when an order has been successfully picked up by the student.
     */
    public function sendOrderCompleted(Order $order): void;

    /**
     * Called when an order is cancelled (either by user or admin).
     */
    public function sendOrderCancelled(Order $order): void;

    /**
     * Called when an order automatically expires due to unpaid timeout.
     */
    public function sendOrderExpired(Order $order): void;
}
