<?php

namespace App\Domain\PaymentGateway\Actions;

class DepositAction
{
    public static function inquiry($orderId, $amount, $timestamp)
    {
        return [
            'order_id' => $orderId,
            'amount' => $amount,
            'status' => 1,
        ];
    }
}
