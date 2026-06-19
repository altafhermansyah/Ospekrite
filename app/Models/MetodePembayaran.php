<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MetodePembayaran extends Model
{
    protected $table = 'metode_pembayaran';
    protected $primaryKey = 'id_metode';
    public $timestamps = false;

    protected $fillable = [
        'nama_bank', 'no_rekening', 'atas_nama'
    ];

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'id_metode', 'id_metode');
    }
}
