<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Domain\Transaction\Actions\CreateDepositAction;
use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\Http;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('deposit')
                ->label('Deposit')
                ->form([
                    TextInput::make('amount')
                        ->required()
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->inputMode('decimal')
                        ->minLength(1)
                        ->numeric()
                ])
                ->action(function(array $data){
                    (new CreateDepositAction)(
                        userId: auth()->user()->id,
                        amount: $data['amount']
                    );
                }),
            Actions\Action::make('withdrawal')
                ->label('withdrawal')
                ->form([
                    TextInput::make('amount')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->inputMode('decimal')
                        ->numeric()
                ])
                ->action(function(array $data){

                }),
        ];
    }
}
