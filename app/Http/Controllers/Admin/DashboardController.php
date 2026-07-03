<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menyiapkan Data Tampung Array $widget untuk Metric Cards di Atas
        $widget = [
            // Hitung akumulasi nominal rupiah dari pesanan yang sudah LUNAS
            'omset_lunas'        => Order::where('status_payment', 'lunas')->sum('total_tagihan'),

            // Hitung total seluruh formulir checkout pre-order yang masuk
            'total_orders'       => Order::count(),

            // Hitung seluruh mahasiswa dan panitia yang terdaftar di sistem
            'total_users'        => User::count(),

            // Hitung pesanan QRIS Statis yang sudah upload bukti dan butuh divalidasi panitia
            'pending_validation' => Order::where('status_payment', 'menunggu_validasi')->count(),
        ];

        // 2. Query Grafik Batang: Hitung Total Penjualan Lunas Tiap Bulan di Tahun 2026 (Chart.js)
        $monthlyRevenue = Order::select(
            DB::raw('MONTH(tanggal_order) as month'),
            DB::raw('SUM(total_tagihan) as total_sales')
        )
            ->where('status_payment', 'lunas')
            ->whereYear('tanggal_order', 2026)
            ->groupBy(DB::raw('MONTH(tanggal_order)'))
            ->get();

        // 3. Query Grafik Donut: Hitung Distribusi Total Pesanan Berdasarkan Fakultas Maba
        $facultyMix = Order::select('fakultas', DB::raw('COUNT(id_order) as total_order'))
            ->groupBy('fakultas')
            ->orderBy('total_order', 'DESC')
            ->get();

        // 4. Lempar Ketiga Variabel Tersebut ke Dalam View Dashboard Panel
        return view('admin.dashboard', compact('widget', 'monthlyRevenue', 'facultyMix'));
    }
}
