<?php

namespace App\Services;

use App\Models\MetodePembayaran;
use App\Models\Order;

/**
 * PembayaranService
 *
 * Responsible for querying and preparing data for the payment page.
 * Thin service — no business mutations happen here (those are in UploadBuktiAction).
 */
class PembayaranService
{
    /**
     * Fetch a single order by no_invoice, including its related payment record.
     * Returns null if not found.
     */
    public function findOrderByInvoice(string $noInvoice): ?Order
    {
        return Order::with(['pembayaran', 'orderItems'])
            ->where('no_invoice', $noInvoice)
            ->first();
    }

    /**
     * Fetch all active payment methods for display on the payment page.
     * These are bank/QRIS accounts that buyers should transfer to.
     */
    public function getMetodePembayaran(): \Illuminate\Database\Eloquent\Collection
    {
        return MetodePembayaran::orderBy('id_metode')->get();
    }

    /**
     * Determine the payment page state based on order's current status_payment.
     * Returns one of: 'form', 'expired', 'lunas', 'ditolak'
     */
    public function resolvePageState(Order $order): string
    {
        $status = $order->status_payment?->value ?? $order->status_payment;

        return match ($status) {
            'lunas'            => 'lunas',
            'expired'          => 'expired',
            'ditolak'          => 'ditolak',    // Show re-upload form
            default            => 'form',        // belum_bayar or menunggu_validasi
        };
    }

    /**
     * Check if the order has already passed its payment deadline.
     */
    public function isExpired(Order $order): bool
    {
        if (!$order->expired_at) {
            return false;
        }

        return $order->expired_at->isPast();
    }
}
