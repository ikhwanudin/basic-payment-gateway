<?php

namespace App\Domain\PaymentGateway\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'status' => 1,
        ];
    }
}
