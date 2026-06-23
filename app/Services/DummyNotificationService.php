<?php

namespace App\Services;

use App\Contracts\NotificationServiceInterface;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class DummyNotificationService implements NotificationServiceInterface
{
    private function logNotification(string $event, Order $order): void
    {
        Log::info("Dummy Notification Sent: {$event}", [
            'invoice' => $order->no_invoice,
            'customer_name' => $order->nama_pembeli,
            'whatsapp' => $order->no_whatsapp,
            'timestamp' => now()->toISOString(),
            'success' => true
        ]);
    }

    public function sendOrderCreated(Order $order): void
    {
        $this->logNotification('ORDER CREATED', $order);
    }

    public function sendPaymentUploaded(Order $order): void
    {
        $this->logNotification('PAYMENT UPLOADED', $order);
    }

    public function sendPaymentVerified(Order $order): void
    {
        $this->logNotification('PAYMENT VERIFIED', $order);
    }

    public function sendOrderReady(Order $order): void
    {
        $this->logNotification('ORDER READY', $order);
    }

    public function sendOrderCompleted(Order $order): void
    {
        $this->logNotification('ORDER COMPLETED', $order);
    }

    public function sendOrderCancelled(Order $order): void
    {
        $this->logNotification('ORDER CANCELLED', $order);
    }

    public function sendOrderExpired(Order $order): void
    {
        $this->logNotification('ORDER EXPIRED', $order);
    }
}
