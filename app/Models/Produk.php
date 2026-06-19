<?php

namespace App\Models;

use App\Models\BundleItem;
use App\Models\Kategori;
use App\Models\ProdukVarian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $timestamps = false;

    protected $fillable = [
        'id_kategori', 'nama_produk', 'harga_dasar',
        'deskripsi', 'gambar_produk'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function varians(): HasMany
    {
        return $this->hasMany(ProdukVarian::class, 'id_produk', 'id_produk');
    }

    public function bundleItems(): HasMany
    {
        return $this->hasMany(BundleItem::class, 'id_produk', 'id_produk');
    }
}
