<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProdukVarian extends Model
{
    protected $table = 'produk_varian';
    protected $primaryKey = 'id_varian';
    public $timestamps = false;

    protected $fillable = [
        'id_produk', 'nama_varian', 'stok', 'harga_tambahan'
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'id_varian', 'id_varian');
    }
}
