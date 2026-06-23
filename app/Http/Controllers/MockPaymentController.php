<?php

namespace App\Http\Controllers;

use App\Contracts\PaymentServiceInterface;
use App\Models\Order;
use Illuminate\Http\Request;

class MockPaymentController extends Controller
{
    public function __construct(
        protected PaymentServiceInterface $paymentService
    ) {}

    public function show(string $invoice)
    {
        $order = Order::where('no_invoice', $invoice)->firstOrFail();

        return view('mock-payment', [
            'order' => $order,
        ]);
    }

    public function simulate(Request $request, string $invoice)
    {
        $request->validate([
            'status' => 'required|in:SUCCESS,FAILED,EXPIRED,CANCELLED',
        ]);

        $order = Order::where('no_invoice', $invoice)->firstOrFail();

        // Construct a mock payload matching what a gateway might send
        $payload = [
            'transaction_id' => 'MOCK-WEBHOOK-' . $order->id_order,
            'order_id' => $invoice,
            'status' => $request->status,
        ];

        // Call the service to handle the callback atomically
        $this->paymentService->handleCallback($payload);

        // Inject the verified session so the user doesn't have to re-enter their WhatsApp number 
        // after returning from the "gateway".
        session(['verified_invoice' => $invoice]);

        return redirect()->route('track.show', $invoice)
            ->with('info', 'Simulasi status pembayaran berhasil diubah menjadi: ' . $request->status);
    }
}
