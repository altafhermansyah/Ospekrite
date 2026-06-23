<?php

namespace App\Http\Controllers;

use App\Actions\UploadBuktiAction;
use App\Exceptions\FileUploadException;
use App\Http\Requests\PembayaranRequest;
use App\Services\CartService;
use App\Services\PembayaranService;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    public function __construct(
        protected PembayaranService $pembayaranService,
        protected UploadBuktiAction $uploadBuktiAction,
        protected CartService       $cartService,
    ) {}

    /**
     * GET /order/{no_invoice}/pembayaran
     * Show the payment page with upload form and method list.
     */
    public function index(string $noInvoice)
    {
        $order = $this->pembayaranService->findOrderByInvoice($noInvoice);

        if (!$order) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        $pageState = $this->pembayaranService->resolvePageState($order);

        // Guard: already confirmed → redirect to tracking
        if ($pageState === 'lunas') {
            return redirect()->route('track.show', $noInvoice)
                ->with('info', 'Pembayaran sudah dikonfirmasi oleh panitia.');
        }

        // Check if order has expired but status not yet updated by scheduler
        if ($this->pembayaranService->isExpired($order) && $pageState === 'form') {
            $pageState = 'expired';
        }

        $metodePembayaran = $this->pembayaranService->getMetodePembayaran();
        $cartCount        = $this->cartService->getCount();

        return view('pembayaran.index', [
            'order'            => $order,
            'pageState'        => $pageState,
            'metodePembayaran' => $metodePembayaran,
            'cartCount'        => $cartCount,
        ]);
    }

    /**
     * POST /order/{no_invoice}/pembayaran
     * Handle proof-of-payment upload.
     */
    public function store(PembayaranRequest $request, string $noInvoice)
    {
        $order = $this->pembayaranService->findOrderByInvoice($noInvoice);

        if (!$order) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        try {
            $this->uploadBuktiAction->execute(
                order:        $order,
                namaPengirim: $request->input('nama_pengirim'),
                file:         $request->file('bukti_transfer'),
            );

            return redirect()->route('pembayaran.sukses', $noInvoice)
                ->with('success', 'Bukti pembayaran berhasil dikirim!');

        } catch (FileUploadException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Payment upload failed', [
                'no_invoice' => $noInvoice,
                'message'    => $e->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengunggah bukti. Silakan coba lagi.');
        }
    }

    /**
     * GET /order/{no_invoice}/pembayaran/sukses
     * Show the success confirmation page.
     */
    public function sukses(string $noInvoice)
    {
        $order = $this->pembayaranService->findOrderByInvoice($noInvoice);

        if (!$order) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        $cartCount = $this->cartService->getCount();

        return view('pembayaran.sukses', [
            'order'     => $order,
            'cartCount' => $cartCount,
        ]);
    }
}
