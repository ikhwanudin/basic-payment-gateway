<?php

namespace App\Domain\Transaction\Utils;

class OrderId
{
    public static function generate(): string
    {
        return config('transaction.order_id.prefix').uniqid();
    }
}
