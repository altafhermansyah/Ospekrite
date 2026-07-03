<?php

namespace App\Exceptions;

use App\Models\Order;
use Exception;

class DuplicateCheckoutException extends Exception
{
    public function __construct(
        private readonly Order $order,
        string $message = 'Pesanan dengan kunci yang sama sudah ada.',
    ) {
        parent::__construct($message);
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}
