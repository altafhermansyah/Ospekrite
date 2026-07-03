<?php

namespace App\Enums;

enum PaymentType: string
{
    case QrisStatis  = 'qris_statis';
    case QrisDinamis = 'qris_dinamis';

    public function label(): string
    {
        return match($this) {
            self::QrisStatis  => 'QRIS Statis',
            self::QrisDinamis => 'QRIS Dinamis',
        };
    }
}
