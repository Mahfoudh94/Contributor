<?php

namespace App\Actions\Wallet;

use Exception;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class SpendCoins
{
    use AsAction;

    /**
     * @throws Exception
     */
    public function handle(int $coins): void
    {
        $wallet = Auth::user()->wallet;

        if (!$wallet || $wallet->coins < $coins) {
            throw new Exception('Not enough coins!');
        }

        $wallet->coins -= $coins;
        $wallet->last_transaction_at = now();
        $wallet->save();

    }
}
