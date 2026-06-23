<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

/**
 * TrackingController — Stage 7A
 *
 * Implements secure guest order tracking.
 * Ownership verification requires both invoice number and WhatsApp number.
 */
class TrackingController extends Controller
{
    /**
     * GET /track
     * Show tracking search form.
     */
    public function index()
    {
        return view('track.index');
    }

    /**
     * POST /track
     * Verify invoice + WhatsApp, redirect to detail.
     */
    public function cari(Request $request)
    {
        $request->validate([
            'no_invoice'  => 'required|string',
            'no_whatsapp' => ['required', 'string', 'regex:/^(\+62|08)[0-9]{8,12}$/'],
        ], [
            'no_invoice.required'  => 'Nomor invoice wajib diisi.',
            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'no_whatsapp.regex'    => 'Format nomor WhatsApp tidak valid (contoh: 0812... atau +62812...).',
        ]);

        $order = Order::with(['orderItems.produkVarian', 'orderItems.bundle', 'pembayaran'])
            ->where('no_invoice', $request->no_invoice)
            ->where('no_whatsapp', $request->no_whatsapp)
            ->first();

        if (!$order) {
            return back()->withErrors([
                'not_found' => 'Pesanan tidak ditemukan. Periksa kembali nomor invoice dan nomor WhatsApp.',
            ])->withInput();
        }

        // Secure session verification
        session(['verified_invoice' => $order->no_invoice]);

        return redirect()->route('track.show', $order->no_invoice);
    }

    /**
     * GET /track/{no_invoice}
     * Order detail — Stage 7A (Placeholder).
     * Do not implement full detail page yet.
     */
    public function show(string $noInvoice)
    {
        // Guard: must have verified ownership via POST /track first
        if (session('verified_invoice') !== $noInvoice) {
            return redirect()->route('track.index')
                ->with('error', 'Silakan verifikasi invoice terlebih dahulu.');
        }

        $order = Order::with(['orderItems.produkVarian', 'orderItems.bundle', 'pembayaran'])
                      ->where('no_invoice', $noInvoice)
                      ->firstOrFail();

        return view('track.show', compact('order'));
    }

    /**
     * POST /order/{no_invoice}/cancel
     * Stage 8A - Order Cancellation for guest users.
     */
    public function cancel(string $noInvoice)
    {
        if (session('verified_invoice') !== $noInvoice) {
            return redirect()->route('track.index')
                ->with('error', 'Silakan verifikasi pesanan terlebih dahulu.');
        }

        $order = Order::where('no_invoice', $noInvoice)->firstOrFail();

        // CANCELLATION RULES
        if ($order->status_order !== \App\Enums\OrderStatus::Pending || 
            $order->status_payment !== \App\Enums\PaymentStatus::BelumBayar) {
            
            // BLOCK CANCELLATION
            return redirect()->route('track.show', $noInvoice)
                ->with('error', 'Pesanan tidak dapat dibatalkan.');
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($order) {
            $order->update([
                'status_order' => \App\Enums\OrderStatus::Batal->value,
            ]);

            // ReleaseStockAction would be called here if stock was previously deducted.
            app(\App\Actions\ReleaseStockAction::class)->execute($order);
        });

        \Illuminate\Support\Facades\Log::info('Order cancelled by user', [
            'no_invoice' => $order->no_invoice,
            'id_order'   => $order->id_order,
        ]);

        app(\App\Contracts\NotificationServiceInterface::class)->sendOrderCancelled($order);

        return redirect()->route('track.show', $noInvoice)
            ->with('info', 'Pesanan berhasil dibatalkan.');
    }
}
