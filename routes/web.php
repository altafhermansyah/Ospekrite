<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\TrackingController;

Route::get('/', [StorefrontController::class, 'index'])->name('home');
Route::get('/produk/{id}', [StorefrontController::class, 'showProduk'])->name('produk.show');
Route::get('/bundle/{id}', [StorefrontController::class, 'showBundle'])->name('bundle.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/data', [CartController::class, 'data'])->name('cart.data');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('throttle:5,1');

// Payment Routes (Stage 6A — Static QRIS)
Route::get('/order/{no_invoice}/pembayaran',        [PembayaranController::class, 'index'])->name('pembayaran.index');
Route::post('/order/{no_invoice}/pembayaran',       [PembayaranController::class, 'store'])->name('pembayaran.store');
Route::get('/order/{no_invoice}/pembayaran/sukses', [PembayaranController::class, 'sukses'])->name('pembayaran.sukses');

// Order Tracking Routes (Stage 6A Stub — full implementation in Stage 7)
Route::get('/track',              [TrackingController::class, 'index'])->name('track.index');
Route::post('/track',             [TrackingController::class, 'cari'])->name('track.cari');
Route::get('/track/{no_invoice}', [TrackingController::class, 'show'])->name('track.show');
Route::post('/order/{no_invoice}/cancel', [TrackingController::class, 'cancel'])->name('order.cancel');

// Mock Payment Routes (Stage 9B)
use App\Http\Controllers\MockPaymentController;
Route::get('/mock-payment/{invoice}', [MockPaymentController::class, 'show'])->name('mock.payment.page');
Route::post('/mock-payment/{invoice}/simulate', [MockPaymentController::class, 'simulate'])->name('mock.payment.simulate');

Route::middleware(['auth', 'admin.only'])->group(function () {
    // Route Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route Manajemen Produk Satuan
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    // Route Manajemen Pesanan (Orders)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    // Route Manajemen Pengguna (Users)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
