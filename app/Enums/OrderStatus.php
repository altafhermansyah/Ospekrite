<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending     = 'pending';
    case Diproses    = 'diproses';
    case SiapDiambil = 'siap_diambil';
    case Selesai     = 'selesai';
    case Batal       = 'batal';
}
