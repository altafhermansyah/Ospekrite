<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $timestamps = false; // Menggunakan `waktu_bayar`

    protected $fillable = [
        'id_order', 'id_metode', 'nama_pengirim',
        'bukti_transfer', 'status_pembayaran',
        'waktu_bayar', 'tipe_pembayaran',
    ];

    protected $casts = [
        'waktu_bayar' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function metodePembayaran(): BelongsTo
    {
        return $this->belongsTo(MetodePembayaran::class, 'id_metode', 'id_metode');
    }
}
