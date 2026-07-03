<?php

namespace App\Services;

use App\Models\Bundle;
use App\Models\ProdukVarian;

/**
 * OrderService
 *
 * Responsible for DB-level re-verification of cart items at checkout time.
 * This service is intentionally separate from CartService:
 * CartService manages session/cookie state.
 * OrderService re-validates everything against the live database.
 */
class OrderService
{
    /**
     * Re-fetch and verify every cart item from the database.
     *
     * Returns an array of enriched items, each with fresh DB-sourced price and stock.
     * Throws InsufficientStockException (with lockForUpdate) during CreateOrderAction.
     * This method only resolves the DB records without locking — locking happens inside
     * the DB::transaction() in CreateOrderAction.
     *
     * @param  array $sessionItems  The 'items' sub-array from session('cart')
     * @return array<string, array>
     * @throws \Exception if a referenced varian or bundle no longer exists
     */
    public function resolveCartItems(array $sessionItems): array
    {
        $resolved = [];

        foreach ($sessionItems as $key => $item) {
            if ($item['tipe'] === 'produk') {
                $varian = ProdukVarian::with('produk')->find($item['id_ref']);

                if (!$varian || !$varian->produk) {
                    throw new \Exception(
                        "Produk varian ID {$item['id_ref']} tidak lagi tersedia. Hapus item dari keranjang dan coba lagi."
                    );
                }

                $resolved[$key] = [
                    'tipe'        => 'produk',
                    'id_ref'      => $item['id_ref'],
                    'qty'         => (int) $item['qty'],
                    'db_harga'    => $varian->produk->harga_dasar + $varian->harga_tambahan,
                    'db_stok'     => (int) $varian->stok,
                    'nama_produk' => $varian->produk->nama_produk,
                    'nama_varian' => $varian->nama_varian,
                ];
            } elseif ($item['tipe'] === 'bundle') {
                $bundle = Bundle::find($item['id_ref']);

                if (!$bundle) {
                    throw new \Exception(
                        "Bundle ID {$item['id_ref']} tidak lagi tersedia. Hapus item dari keranjang dan coba lagi."
                    );
                }

                $resolved[$key] = [
                    'tipe'        => 'bundle',
                    'id_ref'      => $item['id_ref'],
                    'qty'         => (int) $item['qty'],
                    'db_harga'    => (float) $bundle->harga_bundle,
                    'nama_produk' => $bundle->nama_bundle,
                    'nama_varian' => null,
                ];
            }
        }

        return $resolved;
    }

    /**
     * Calculate total_tagihan from DB-sourced prices.
     * Never trust session or frontend subtotals.
     */
    public function calculateTotal(array $resolvedItems): int
    {
        $total = 0;
        foreach ($resolvedItems as $item) {
            $total += (int) round($item['db_harga'] * $item['qty']);
        }
        return $total;
    }
}
