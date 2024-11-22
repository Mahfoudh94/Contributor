<?php
namespace App\Http\Controllers;

use App\Actions\Wallet\GetWalletBalance;
use App\Actions\Wallet\SpendCoins;
use App\Http\Requests\Wallet\SpendCoinsRequest;
use Exception;

class WalletController extends Controller
{
    // Get user's coin balance
    public function getBalance()
    {
        $balance = GetWalletBalance::run();

        return response()->json($balance);
    }

    // Spend coins for AI service or tasks
    public function spendCoins(SpendCoinsRequest $request)
    {
        try {
            SpendCoins::run($request->validated()['coins']);
            return response()->json(['message' => 'Coins spent successfully!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
