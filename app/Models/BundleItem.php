<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $table = 'order_item';
    protected $primaryKey = 'id_order_item';
    public $timestamps = false;

    protected $fillable = [
        'id_order', 'id_varian', 'id_bundle', 'qty',
        'harga_satuan', 'detail_varian'
    ];

    protected $casts = [
        'detail_varian' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function varian(): BelongsTo
    {
        return $this->belongsTo(ProdukVarian::class, 'id_varian', 'id_varian');
    }

    public function bundle(): BelongsTo
    {
        return $this->belongsTo(Bundle::class, 'id_bundle', 'id_bundle');
    }
}
