<?php

namespace App\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    public function __construct(
        string $message = 'Stok tidak mencukupi.',
        private readonly ?string $itemName = null,
        private readonly int $requested  = 0,
        private readonly int $available  = 0,
    ) {
        parent::__construct($message);
    }

    public function getItemName(): ?string
    {
        return $this->itemName;
    }

    public function getRequested(): int
    {
        return $this->requested;
    }

    public function getAvailable(): int
    {
        return $this->available;
    }
}
