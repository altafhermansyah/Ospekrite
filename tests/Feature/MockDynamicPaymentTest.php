<?php

namespace Tests\Feature;

use App\Contracts\PaymentServiceInterface;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Models\Order;
use App\Models\Produk;
use App\Models\ProdukVarian;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MockDynamicPaymentTest extends TestCase
{
    use RefreshDatabase;

    private function createOrder()
    {
        $produk = Produk::create([
            'id_kategori' => 1, // Assume exists or not strictly constrained
            'nama_produk' => 'Test Produk',
            'harga_dasar' => 50000,
        ]);

        $varian = ProdukVarian::create([
            'id_produk' => $produk->id_produk,
            'nama_varian' => 'L',
            'stok' => 10,
            'harga_tambahan' => 0,
        ]);

        $order = Order::create([
            'no_invoice' => 'OSP-DYN-' . uniqid(),
            'nama_pembeli' => 'Dynamic Tester',
            'nim' => '123456',
            'no_whatsapp' => '08123456',
            'fakultas' => 'FST',
            'total_tagihan' => 100000,
            'payment_type' => PaymentType::QrisDinamis,
            'status_payment' => PaymentStatus::BelumBayar,
            'status_order' => OrderStatus::Pending,
            'tanggal_order' => now(),
            'idempotency_key' => uniqid(),
        ]);

        OrderItem::create([
            'id_order' => $order->id_order,
            'id_varian' => $varian->id_varian,
            'qty' => 2,
            'harga_satuan' => 50000,
            'detail_varian' => json_encode(['nama_produk' => 'Test', 'nama_varian' => 'L']),
        ]);

        return [$order, $varian];
    }

    public function test_success_callback_deducts_stock_and_updates_status()
    {
        [$order, $varian] = $this->createOrder();

        $payload = [
            'transaction_id' => 'MOCK-123',
            'order_id' => $order->no_invoice,
            'status' => 'SUCCESS',
        ];

        app(PaymentServiceInterface::class)->handleCallback($payload);

        $order->refresh();
        $varian->refresh();

        $this->assertEquals(PaymentStatus::Lunas, $order->status_payment);
        $this->assertEquals(OrderStatus::Diproses, $order->status_order);
        // Initial stock 10, bought 2, remaining 8
        $this->assertEquals(8, $varian->stok);
    }

    public function test_double_success_callback_is_idempotent_and_does_not_deduct_stock_twice()
    {
        [$order, $varian] = $this->createOrder();

        $payload = [
            'transaction_id' => 'MOCK-123',
            'order_id' => $order->no_invoice,
            'status' => 'SUCCESS',
        ];

        // First callback
        app(PaymentServiceInterface::class)->handleCallback($payload);

        // Second callback (duplicate)
        app(PaymentServiceInterface::class)->handleCallback($payload);

        $order->refresh();
        $varian->refresh();

        $this->assertEquals(PaymentStatus::Lunas, $order->status_payment);
        // Stock must still be 8, not 6
        $this->assertEquals(8, $varian->stok);
    }

    public function test_failed_callback_updates_status()
    {
        [$order, $varian] = $this->createOrder();

        $payload = [
            'transaction_id' => 'MOCK-123',
            'order_id' => $order->no_invoice,
            'status' => 'FAILED',
        ];

        app(PaymentServiceInterface::class)->handleCallback($payload);

        $order->refresh();
        $varian->refresh();

        $this->assertEquals(PaymentStatus::BelumBayar, $order->status_payment);
        $this->assertEquals(OrderStatus::Pending, $order->status_order);
        $this->assertEquals(10, $varian->stok); // No stock deducted
    }

    public function test_expired_callback_updates_status_and_order()
    {
        [$order, $varian] = $this->createOrder();

        $payload = [
            'transaction_id' => 'MOCK-123',
            'order_id' => $order->no_invoice,
            'status' => 'EXPIRED',
        ];

        app(PaymentServiceInterface::class)->handleCallback($payload);

        $order->refresh();
        $varian->refresh();

        $this->assertEquals(PaymentStatus::Expired, $order->status_payment);
        $this->assertEquals(OrderStatus::Batal, $order->status_order);
        $this->assertEquals(10, $varian->stok); // No stock deducted
    }
}
