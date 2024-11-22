<?php

namespace App\Actions\Wallet;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class GetWalletBalance
{
    use AsAction;

    public function handle(): array
    {
        $wallet = Auth::user()->wallet;

        return [
            'coins' => $wallet->coins ?? 0,
            'last_transaction_at' => $wallet->last_transaction_at ?? null,
        ];
    }
}
