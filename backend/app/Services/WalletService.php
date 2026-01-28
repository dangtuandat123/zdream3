<?php

namespace App\Services;

use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function checkBalance(User $user): float
    {
        return $user->credits;
    }

    public function deductCredits(User $user, float $amount, string $reason, ?string $referenceId = null): bool
    {
        if ($user->credits < $amount) {
            return false;
        }

        DB::transaction(function () use ($user, $amount, $reason, $referenceId) {
            $balanceBefore = $user->credits;
            $user->credits -= $amount;
            $user->save();

            WalletTransaction::create([
                'user_id' => $user->id,
                'type' => 'debit',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $user->credits,
                'reason' => $reason,
                'reference_id' => $referenceId,
            ]);
        });

        return true;
    }

    public function refundCredits(User $user, float $amount, string $reason, ?string $referenceId = null): void
    {
        DB::transaction(function () use ($user, $amount, $reason, $referenceId) {
            $balanceBefore = $user->credits;
            $user->credits += $amount;
            $user->save();

            WalletTransaction::create([
                'user_id' => $user->id,
                'type' => 'credit',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $user->credits,
                'reason' => $reason,
                'reference_id' => $referenceId,
            ]);
        });
    }
}
