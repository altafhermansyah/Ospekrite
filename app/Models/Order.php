<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    public $timestamps = false; // Menggunakan custom `tanggal_order`

    protected $fillable = [
        'id_user', 'no_invoice', 'total_tagihan',
        'status_order', 'status_payment',
        'nama_pembeli', 'nim', 'no_whatsapp', 'fakultas',
        'email', 'catatan', 'idempotency_key',
        'tanggal_order', 'expired_at',
        'payment_type', 'payment_channel',
    ];

    protected $casts = [
        'tanggal_order' => 'datetime',
        'expired_at'    => 'datetime',
        'status_order'  => OrderStatus::class,
        'status_payment' => PaymentStatus::class,
        'payment_type'  => PaymentType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'id_order', 'id_order');
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'id_order', 'id_order');
    }
}
