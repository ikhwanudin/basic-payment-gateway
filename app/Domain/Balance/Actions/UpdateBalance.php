<?php

namespace App\Domain\Balance\Actions;

use App\Models\UserBalance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateBalance
{
    /**
     * update balance using pesimistic locking
     * @param $user_id
     * @param $balance
     * @param $action - deposit or withdraw
     * @return void
     */
    public function __invoke($user_id, $balance, $action)
    {
        DB::transaction(function () use ($user_id, $balance, $action) {
            $userBalance = UserBalance::lockForUpdate()->where('user_id', $user_id)->first();

            if(!$userBalance && $action == 'deposit') {
                $userBalance = UserBalance::create([
                    'user_id' => $user_id,
                    'balance' => $balance,
                ]);
            }elseif (!$userBalance && $action == 'withdraw') {
                //todo: handle insufficient balance && error handling
                Log::error('insufficient balance');
            }

            if ($action == 'deposit') {
                $userBalance->increment('balance', $balance);
            }elseif ($action == 'withdraw') {
                $userBalance->decrement('balance', $balance);
            }

            Log::info($userBalance->get()->toArray());
            Log::info($action);
            Log::info('balance updated');

        });
    }
}
