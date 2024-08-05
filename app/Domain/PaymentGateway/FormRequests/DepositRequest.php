<?php

namespace App\Domain\PaymentGateway\FormRequests;

use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
{
    public function rules()
    {
        return [
            'order_id' => 'required|string',
            'amount' => 'required|decimal:2',
            'timestamp' => 'required|date',
        ];
    }
}
