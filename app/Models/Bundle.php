<?php

namespace App\Models;

use App\Models\BundleItem;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bundle extends Model
{
    protected $table = 'bundle';
    protected $primaryKey = 'id_bundle';
    public $timestamps = false;

    protected $fillable = [
        'nama_bundle', 'deskripsi', 'harga_bundle', 'gambar_bundle'
    ];

    public function bundleItems(): HasMany
    {
        return $this->hasMany(BundleItem::class, 'id_bundle', 'id_bundle');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'id_bundle', 'id_bundle');
    }
}
