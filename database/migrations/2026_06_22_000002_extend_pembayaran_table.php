<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Extend the pembayaran table with payment type column.
     */
    public function up(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->enum('tipe_pembayaran', ['qris_statis', 'qris_dinamis'])
                  ->default('qris_statis')
                  ->after('status_pembayaran');
        });
    }

    /**
     * Reverse the extension of the pembayaran table.
     */
    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropColumn('tipe_pembayaran');
        });
    }
};
