<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Make no_invoice nullable so we can insert the order row first,
     * retrieve the auto-incremented id_order, generate the invoice number
     * from it (OSP-YYYY-000001), and then update the row in a single transaction.
     *
     * Without this, MySQL rejects the INSERT because no_invoice is NOT NULL
     * but we intentionally pass null on the first write.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('no_invoice', 100)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Note: reverting to NOT NULL will fail if any rows have null no_invoice
            $table->string('no_invoice', 100)->nullable(false)->change();
        });
    }
};
