<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait Helpers
{
    public function stats($user)
    {
        $userId = $user->id;
        $stats = DB::table('holdings')
            ->select(
                'user_id',
                DB::raw('0 AS outstanding_balance'),
                DB::raw('SUM(IFNULL(sell_after_commission, 0)) - SUM(IFNULL(debit, 0)) AS cash_balance'),
                DB::raw('SUM(CASE WHEN type = "Buy" THEN purchase ELSE 0 END) AS total_invested'),
                DB::raw('SUM(CASE WHEN type = "Sell" THEN sell_after_commission ELSE 0 END) AS total_cash_received'),
                DB::raw('SUM(sell) - SUM(sell_after_commission) AS margin_amount')
            )
            ->where('user_id', $userId)
            ->groupBy('user_id')
            ->get()
            ->first();

        // If holdings stats are null, initialize them to zero
        if (is_null($stats)) {
            $stats = (object) [
                'account_balance' => 0,
                'cash_balance' => 0,
                'outstanding_balance' => 0,
                'margin_amount' => 0,
            ];
        } else {
            // Calculate account balance from holdings data
            $stats->account_balance = ($stats->total_invested - $stats->total_cash_received);
        }

        return $stats;
    }
}

