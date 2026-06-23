<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExpireOrdersTest extends TestCase
{
    use RefreshDatabase;

    private function createOrder(array $attributes = [])
    {
        $default = [
            'id_user' => null,
            'no_invoice' => 'OSP-2026-TEST',
            'nama_pembeli' => 'John Doe',
            'nim' => '12345678',
            'no_whatsapp' => '08123456789',
            'fakultas' => 'FST',
            'total_tagihan' => 100000,
            'payment_type' => PaymentType::QrisStatis,
            'tanggal_order' => now(),
            'status_order' => OrderStatus::Pending,
            'status_payment' => PaymentStatus::BelumBayar,
            'expired_at' => now()->addHours(24),
            'idempotency_key' => uniqid(),
        ];

        return Order::create(array_merge($default, $attributes));
    }

    public function test_order_expired_after_deadline()
    {
        // Arrange
        $order = $this->createOrder([
            'expired_at' => now()->subMinutes(5), // Passed deadline
        ]);

        // Act
        $this->artisan('orders:expire')
            ->expectsOutputToContain('Successfully expired 1 orders.')
            ->assertExitCode(0);

        // Assert
        $order->refresh();
        $this->assertEquals(OrderStatus::Batal, $order->status_order);
        $this->assertEquals(PaymentStatus::Expired, $order->status_payment);
    }

    public function test_active_order_not_expired()
    {
        // Arrange
        $order = $this->createOrder([
            'expired_at' => now()->addHours(1), // Future deadline
        ]);

        // Act
        $this->artisan('orders:expire')
            ->expectsOutputToContain('No expired orders found.')
            ->assertExitCode(0);

        // Assert
        $order->refresh();
        $this->assertEquals(OrderStatus::Pending, $order->status_order);
        $this->assertEquals(PaymentStatus::BelumBayar, $order->status_payment);
    }

    public function test_command_is_idempotent()
    {
        // Arrange
        $order = $this->createOrder([
            'status_payment' => PaymentStatus::MenungguValidasi,
            'expired_at' => now()->subHour(),
        ]);

        // Act: First Run
        $this->artisan('orders:expire')
            ->expectsOutputToContain('Successfully expired 1 orders.')
            ->assertExitCode(0);

        // Assert first run
        $order->refresh();
        $this->assertEquals(OrderStatus::Batal, $order->status_order);
        $this->assertEquals(PaymentStatus::Expired, $order->status_payment);

        // Act: Second Run (Idempotency check)
        $this->artisan('orders:expire')
            ->expectsOutputToContain('No expired orders found.')
            ->assertExitCode(0);

        // Assert second run doesn't change anything back
        $order->refresh();
        $this->assertEquals(OrderStatus::Batal, $order->status_order);
        $this->assertEquals(PaymentStatus::Expired, $order->status_payment);
    }
}
