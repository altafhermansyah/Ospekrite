<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Contoh mengambil data dinamis untuk metrics dashboard
        $totalPendapatan = Order::where('status_order', 'lunas')->sum('total_tagihan');
        $totalPesanan = Order::count();
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $pesananPending = Order::where('status_order', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalPendapatan',
            'totalPesanan',
            'totalMahasiswa',
            'pesananPending'
        ));
    }
}
