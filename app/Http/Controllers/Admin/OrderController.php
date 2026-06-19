<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'pembayaran'])
                        ->orderBy('tanggal_order', 'DESC')
                        ->get();

        return view('admin.orders.index', compact('orders'));
    }
}
