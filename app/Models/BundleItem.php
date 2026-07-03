<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BundleItem extends Model
{
    protected $table = 'bundle_item';
    protected $primaryKey = 'id_bundle_item';
    public $timestamps = false;

    protected $fillable = [
        'id_bundle', 'id_produk', 'qty',
    ];

    public function bundle(): BelongsTo
    {
        return $this->belongsTo(Bundle::class, 'id_bundle', 'id_bundle');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
