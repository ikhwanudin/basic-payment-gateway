<?php

namespace App\Filament\Widgets;

use App\Domain\Balance\Actions\GetBalance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BalanceWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $user_id = auth()->user()->id;
        $balance = (new GetBalance)($user_id);

        return [
            Stat::make('User balance', number_format($balance, 2, ',', '.')),
        ];
    }
}
