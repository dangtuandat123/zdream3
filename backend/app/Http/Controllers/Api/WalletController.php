<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WalletService;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function balance(Request $request)
    {
        return response()->json([
            'credits' => $request->user()->credits
        ]);
    }

    public function history(Request $request)
    {
        $transactions = $request->user()->walletTransactions()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($transactions);
    }
}
