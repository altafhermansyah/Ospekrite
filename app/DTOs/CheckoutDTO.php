<?php

namespace App\DTOs;

class CheckoutDTO
{
    public function __construct(
        public readonly string  $nama_pembeli,
        public readonly string  $nim,
        public readonly string  $no_whatsapp,
        public readonly string  $fakultas,
        public readonly ?string $email,
        public readonly ?string $catatan,
        public readonly string  $payment_type,
        public readonly string  $idempotency_key,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            nama_pembeli     : $data['nama_pembeli'],
            nim              : $data['nim'],
            no_whatsapp      : $data['no_whatsapp'],
            fakultas         : $data['fakultas'],
            email            : $data['email'] ?? null,
            catatan          : $data['catatan'] ?? null,
            payment_type     : $data['payment_type'],
            idempotency_key  : $data['idempotency_key'],
        );
    }
}
