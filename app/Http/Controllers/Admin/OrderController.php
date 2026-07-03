<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['pembayaran'])
            ->orderBy('tanggal_order', 'DESC')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }
    public function updateStatus(Request $request, $id)
    {
        // 1. Validasi input ketat sesuai dengan nilai ENUM di skema database baru
        $request->validate([
            'status_payment' => 'required|in:belum_bayar,menunggu_validasi,lunas,ditolak,expired',
            'status_order'   => 'required|in:pending,diproses,siap_diambil,selesai,batal',
        ]);

        $order = Order::with('pembayaran')->findOrFail($id);

        DB::beginTransaction();

        try {
            // 2. Update kolom status langsung di tabel induk orders
            $order->update([
                'status_payment' => $request->status_payment,
                'status_order'   => $request->status_order,
            ]);

            // 3. Efek Domino: Sinkronisasi status pembayaran ke tabel pembayaran (jika maba sudah upload bukti)
            if ($order->pembayaran) {
                // Map kecocokan status pembayaran orders ke tabel pembayaran ('menunggu_validasi','lunas','ditolak')
                $mapStatuspembayaran = [
                    'lunas'             => 'lunas',
                    'ditolak'           => 'ditolak',
                    'menunggu_validasi' => 'menunggu_validasi',
                    'belum_bayar'       => 'menunggu_validasi',
                    'expired'           => 'ditolak'
                ];

                $order->pembayaran->update([
                    'status_pembayaran' => $mapStatuspembayaran[$request->status_payment] ?? 'menunggu_validasi'
                ]);
            }

            DB::commit();
            return redirect()->route('orders.index')->with('success', 'Status order #' . ($order->no_invoice ?? 'Maba') . ' berhasil divalidasi!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal memproses validasi: ' . $e->getMessage());
        }
    }
}
