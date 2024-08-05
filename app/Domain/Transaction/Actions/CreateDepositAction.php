<?php

namespace App\Domain\Transaction\Actions;

use App\Domain\Balance\Actions\UpdateBalance;
use App\Domain\PaymentGateway\Actions\DepositAction;
use App\Domain\Transaction\Utils\OrderId;
use App\Models\UserTransaction;
use http\Client\Request;
use Illuminate\Support\Facades\Http;

class CreateDepositAction
{
    public function __invoke($userId, $amount)
    {
        try{
            $orderId = OrderId::generate();

            /*
             * note: di pake untuk external consume api
             $requestDeposit = $this->reqHttpDeposit([
                'order_id' => $orderId,
                'amount' => $amount,
                'timestamp' => now(),
            ]);
            */

            $requestDeposit = DepositAction::inquiry($orderId, $amount, now());

            UserTransaction::create([
                'user_id' => $userId,
                'order_id' => $requestDeposit['order_id'],
                'ref_id' => $requestDeposit['order_id'],
                'trx_type' => 'deposit',
                'amount' => $requestDeposit['amount'],
                'final_amount' => $requestDeposit['amount'],
                'status' => 1,
            ]);

            //async update balance
            //todo: use separate job class
            dispatch(function() use($userId, $amount) {
                (new UpdateBalance)($userId, $amount, 'deposit');
            });

            return $orderId;

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * consume deposit api
     * @throws \Exception
     */
    public function reqHttpDeposit(array $body)
    {
        $request = Http::withHeaders([
            'Authorization' => config('api.secret')
        ])
            ->post(config('transaction.base_url') . '/api/deposit', $body);


        if($request->failed()) {
            throw new \Exception($request->body());
        }

        return $request->body();
    }
}
