<?php

namespace App\Domain\PaymentGateway\Controllers;

use App\Domain\PaymentGateway\FormRequests\DepositRequest;
use App\Domain\PaymentGateway\Resources\DepositResource;
use App\Http\Controllers\Controller;

class DepositController extends Controller
{
    public function __invoke(DepositRequest $request)
    {
        $validatedRequest = $request->validated();

        return new DepositResource([]);
    }
}
