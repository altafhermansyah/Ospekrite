<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Extend the orders table for guest checkout support.
     *
     * Adds buyer info, idempotency, expiration, payment type, and status columns.
     * Makes id_user nullable to support guest orders (no account required).
     */
    public function up(): void
{
    Schema::table('orders', function (Blueprint $table) {
        // Buyer information (guest checkout)
        $table->string('nama_pembeli', 255)->after('id_user');
        $table->string('nim', 50)->after('nama_pembeli');
        $table->string('no_whatsapp', 20)->after('nim');
        $table->string('fakultas', 100)->after('no_whatsapp');
        $table->string('email', 255)->nullable()->after('fakultas');
        $table->text('catatan')->nullable()->after('email');

        // Idempotency & expiration
        $table->string('idempotency_key', 64)->unique()->after('catatan');
        $table->timestamp('expired_at')->nullable()->after('idempotency_key');

        // Payment type & channel
        $table->enum('payment_type', ['qris_statis', 'qris_dinamis'])
              ->default('qris_statis')
              ->after('expired_at');
        $table->string('payment_channel', 100)->nullable()->after('payment_type');

        // Payment status
        $table->enum('status_payment', [
            'belum_bayar', 'menunggu_validasi', 'lunas', 'ditolak', 'expired',
        ])->default('belum_bayar')->after('status_order');

        // DIHAPUS: tanggal_order sudah ada
        // DIHAPUS: id_user->change() sudah nullable
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropUnique(['idempotency_key']);

        $table->dropColumn([
            'nama_pembeli',
            'nim',
            'no_whatsapp',
            'fakultas',
            'email',
            'catatan',
            'idempotency_key',
            'expired_at',
            'payment_type',
            'payment_channel',
            'status_payment',
            // DIHAPUS: tanggal_order dari sini juga
        ]);
    });
    }
};
