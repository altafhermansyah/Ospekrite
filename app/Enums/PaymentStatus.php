<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case BelumBayar       = 'belum_bayar';
    case MenungguValidasi = 'menunggu_validasi';
    case Lunas            = 'lunas';
    case Ditolak          = 'ditolak';
    case Expired          = 'expired';
}
