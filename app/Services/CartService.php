<?php

namespace App\Services;

use App\Models\Bundle;
use App\Models\ProdukVarian;
use App\Exceptions\InsufficientStockException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected const COOKIE_NAME = 'ospekrite_cart';
    protected const COOKIE_TTL = 10080; // 7 days in minutes
    protected const MAX_QTY = 10;

    public function restoreFromCookie(): void
    {
        if (!Session::has('cart') && Cookie::has(self::COOKIE_NAME)) {
            $cartData = json_decode(Cookie::get(self::COOKIE_NAME), true);
            if (is_array($cartData)) {
                Session::put('cart', $cartData);
            }
        }
    }

    public function syncToCookie(): void
    {
        $cartData = Session::get('cart', ['items' => [], 'total' => 0]);
        Cookie::queue(self::COOKIE_NAME, json_encode($cartData), self::COOKIE_TTL);
    }

    public function getCart(): array
    {
        $this->restoreFromCookie();
        return Session::get('cart', ['items' => [], 'total' => 0]);
    }

    public function getCount(): int
    {
        $cart = $this->getCart();
        $count = 0;
        foreach ($cart['items'] ?? [] as $item) {
            $count += $item['qty'];
        }
        return $count;
    }

    public function recalculateTotal(): void
    {
        $cart = Session::get('cart', ['items' => [], 'total' => 0]);
        $total = 0;
        foreach ($cart['items'] ?? [] as $item) {
            $total += $item['harga'] * $item['qty'];
        }
        $cart['total'] = $total;
        Session::put('cart', $cart);
    }

    public function add(string $tipe, int $idRef, int $qty): void
    {
        $this->restoreFromCookie();
        $cart = Session::get('cart', ['items' => [], 'total' => 0]);

        $key = "{$tipe}_{$idRef}";
        $currentQty = isset($cart['items'][$key]) ? $cart['items'][$key]['qty'] : 0;
        $newQty = $currentQty + $qty;

        if ($tipe === 'produk') {
            $varian = ProdukVarian::with('produk')->find($idRef);
            if (!$varian) {
                throw new \Exception('Varian produk tidak ditemukan.');
            }

            $maxStock = min($varian->stok, self::MAX_QTY);
            if ($newQty > $maxStock) {
                if ($varian->stok == 0) {
                    throw new InsufficientStockException('Stok varian habis.');
                }
                $newQty = $maxStock;
            }

            $harga = $varian->produk->harga_dasar + $varian->harga_tambahan;

            $cart['items'][$key] = [
                'tipe' => 'produk',
                'id_ref' => $idRef,
                'nama' => $varian->produk->nama_produk,
                'nama_varian' => $varian->nama_varian,
                'harga' => $harga,
                'qty' => $newQty,
                'gambar' => $varian->produk->gambar_produk
            ];
        } elseif ($tipe === 'bundle') {
            $bundle = Bundle::with('bundleItems.produk.produkVarian')->find($idRef);
            if (!$bundle) {
                throw new \Exception('Bundle tidak ditemukan.');
            }

            $availableStock = PHP_INT_MAX;
            foreach ($bundle->bundleItems as $bItem) {
                $itemTotalStock = $bItem->produk->produkVarian->sum('stok');
                $bundleCapacity = floor($itemTotalStock / $bItem->qty);
                if ($bundleCapacity < $availableStock) {
                    $availableStock = $bundleCapacity;
                }
            }

            $maxStock = min($availableStock, self::MAX_QTY);
            if ($newQty > $maxStock) {
                if ($availableStock <= 0) {
                    throw new InsufficientStockException('Stok item dalam bundle habis.');
                }
                $newQty = $maxStock;
            }

            $cart['items'][$key] = [
                'tipe' => 'bundle',
                'id_ref' => $idRef,
                'nama' => $bundle->nama_bundle,
                'harga' => $bundle->harga_bundle,
                'qty' => $newQty,
                'gambar' => null // Use a default or empty string if bundle doesn't have an image field
            ];
        } else {
            throw new \InvalidArgumentException('Tipe item tidak valid.');
        }

        Session::put('cart', $cart);
        $this->recalculateTotal();
        $this->syncToCookie();
    }

    public function update(string $key, int $qty): void
    {
        $this->restoreFromCookie();
        $cart = Session::get('cart', ['items' => [], 'total' => 0]);

        if (!isset($cart['items'][$key])) {
            throw new \Exception('Item tidak ada di keranjang.');
        }

        $item = $cart['items'][$key];
        
        if ($item['tipe'] === 'produk') {
            $varian = ProdukVarian::find($item['id_ref']);
            if (!$varian) {
                $this->remove($key);
                throw new \Exception('Varian produk tidak ditemukan.');
            }
            $maxStock = min($varian->stok, self::MAX_QTY);
            if ($qty > $maxStock) {
                if ($varian->stok == 0) {
                    throw new InsufficientStockException('Stok varian habis.');
                }
                $qty = $maxStock;
            }
        } elseif ($item['tipe'] === 'bundle') {
            $bundle = Bundle::with('bundleItems.produk.produkVarian')->find($item['id_ref']);
            if (!$bundle) {
                $this->remove($key);
                throw new \Exception('Bundle tidak ditemukan.');
            }

            $availableStock = PHP_INT_MAX;
            foreach ($bundle->bundleItems as $bItem) {
                $itemTotalStock = $bItem->produk->produkVarian->sum('stok');
                $bundleCapacity = floor($itemTotalStock / $bItem->qty);
                if ($bundleCapacity < $availableStock) {
                    $availableStock = $bundleCapacity;
                }
            }
            
            $maxStock = min($availableStock, self::MAX_QTY);
            if ($qty > $maxStock) {
                if ($availableStock <= 0) {
                    throw new InsufficientStockException('Stok item dalam bundle habis.');
                }
                $qty = $maxStock;
            }
        }

        $cart['items'][$key]['qty'] = $qty;
        Session::put('cart', $cart);
        $this->recalculateTotal();
        $this->syncToCookie();
    }

    public function remove(string $key): void
    {
        $this->restoreFromCookie();
        $cart = Session::get('cart', ['items' => [], 'total' => 0]);

        if (isset($cart['items'][$key])) {
            unset($cart['items'][$key]);
            Session::put('cart', $cart);
            $this->recalculateTotal();
            $this->syncToCookie();
        }
    }

    public function clear(): void
    {
        Session::forget('cart');
        Cookie::queue(Cookie::forget(self::COOKIE_NAME));
    }
}
