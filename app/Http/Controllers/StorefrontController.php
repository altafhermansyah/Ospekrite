<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $kategoriId = $request->input('kategori');

        $produkQuery = Produk::with(['kategori', 'produkVarian']);

        if ($query) {
            $produkQuery->where(function ($q) use ($query) {
                $q->where('nama_produk', 'like', "%{$query}%")
                  ->orWhereHas('kategori', function ($q2) use ($query) {
                      $q2->where('nama_kategori', 'like', "%{$query}%");
                  });
            });
        }

        if ($kategoriId) {
            $produkQuery->where('id_kategori', $kategoriId);
        }

        // Apply pagination: 12 items per page
        $produk = $produkQuery->paginate(12)->withQueryString();

        // Newest products (latest 4 by id_produk or any sort order, assuming no created_at)
        $newestProduk = Produk::with(['kategori', 'produkVarian'])
            ->orderBy('id_produk', 'desc')
            ->take(4)
            ->get();

        // Bundles
        $bundles = Bundle::with(['bundleItems.produk.produkVarian'])->get();

        // Categories for filter
        $kategoriList = Kategori::all();

        return view('welcome', compact('produk', 'newestProduk', 'bundles', 'kategoriList', 'query', 'kategoriId'));
    }

    public function showProduk($id)
    {
        $produk = Produk::with(['kategori', 'produkVarian'])->findOrFail($id);

        $relatedProducts = Produk::with(['kategori', 'produkVarian'])
            ->where('id_kategori', $produk->id_kategori)
            ->where('id_produk', '!=', $id)
            ->take(4)
            ->get();

        return view('produk.show', compact('produk', 'relatedProducts'));
    }

    public function showBundle($id)
    {
        $bundle = Bundle::with(['bundleItems.produk.produkVarian'])->findOrFail($id);
        
        return view('bundle.show', compact('bundle'));
    }
}
