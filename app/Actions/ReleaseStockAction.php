<?php

namespace App\Actions;

use App\Models\Order;
use App\Models\ProdukVarian;
use App\Models\Bundle;
use App\Models\BundleItem;
use Illuminate\Support\Facades\Log;

class ReleaseStockAction
{
    /**
     * Restore stock for cancelled/expired orders if it was previously deducted.
     * 
     * Note: In the current QRIS Statis flow, stock is NOT deducted during checkout,
     * but only after payment is confirmed. This action is prepared for future
     * dynamic payment flows where stock might be temporarily reserved/deducted
     * upon order creation.
     */
    public function execute(Order $order): void
    {
        // Currently QRIS Statis does not deduct stock on checkout.
        // Therefore, if the order is still "belum_bayar", no stock was deducted.
        // We only restore stock if we actually implemented dynamic payment deduction.
        // For Stage 8A, we keep it as a stub.

        /*
        // Example implementation for future dynamic payment:
        foreach ($order->orderItems as $item) {
            if ($item->id_bundle) {
                $bundle = Bundle::with('bundleItems')->find($item->id_bundle);
                if ($bundle) {
                    foreach ($bundle->bundleItems as $bundleItem) {
                        ProdukVarian::where('id_produk', $bundleItem->id_produk)
                            ->increment('stok', $bundleItem->qty * $item->qty);
                    }
                }
            } else {
                ProdukVarian::where('id_varian', $item->id_varian)
                    ->increment('stok', $item->qty);
            }
        }
        */

        Log::info('ReleaseStockAction executed', [
            'id_order' => $order->id_order,
            'note' => 'No stock restored because QRIS Statis does not deduct on checkout.'
        ]);
    }
}
