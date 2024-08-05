<?php

namespace App\Domain\Balance\Actions;

use App\Models\UserBalance;

class GetBalance
{
    public function __invoke($user_id)
    {
        return UserBalance::where('user_id', $user_id)
            ->select('balance')
            ->first()
            ->balance ?? 0;
    }
}
