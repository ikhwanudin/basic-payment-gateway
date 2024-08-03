<?php

use App\Domain\PaymentGateway\Controllers\DepositController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/deposit', DepositController::class);
