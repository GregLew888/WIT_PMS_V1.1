<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HoldingSeeder extends Seeder
{
    public function run()
    {
        $userId = 4;
        $now = Carbon::now();

        DB::table('holdings')->insert([
            [
                'user_id' => $userId,
                'transaction_no' => 'TXN001',
                'symbol' => 'AAPL',
                'stock_name' => 'Apple Inc.',
                'no_of_shares' => 10,
                'unit_price' => 150.00,
                'trade_date' => $now->subDays(10),
                'purchase' => 1500.00,
                'current' => 160.00,
                'sell' => 0,
                'commission' => 0,
                'profit_loss' => 0,
                'total' => 1500.00,
                'status' => 'open',
                'type' => 'buy',
                'remaining' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => $userId,
                'transaction_no' => 'TXN002',
                'symbol' => 'GOOGL',
                'stock_name' => 'Alphabet Inc.',
                'no_of_shares' => 5,
                'unit_price' => 200.00,
                'trade_date' => $now->subDays(15),
                'purchase' => 1000.00,
                'current' => 205.00,
                'sell' => 0,
                'commission' => 0,
                'profit_loss' => 0,
                'total' => 1000.00,
                'status' => 'open',
                'type' => 'buy',
                'remaining' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => $userId,
                'transaction_no' => 'TXN003',
                'symbol' => 'AAPL',
                'stock_name' => 'Apple Inc.',
                'no_of_shares' => 5,
                'unit_price' => 160.00,
                'trade_date' => $now->subDays(7),
                'purchase' => 800.00,
                'current' => 165.00,
                'sell' => 825.00,
                'commission' => 5.00,
                'profit_loss' => 20.00,
                'total' => 820.00, // Sell - commission
                'status' => 'closed',
                'type' => 'sell',
                'remaining' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => $userId,
                'transaction_no' => 'TXN004',
                'symbol' => 'TSLA',
                'stock_name' => 'Tesla Inc.',
                'no_of_shares' => 8,
                'unit_price' => 300.00,
                'trade_date' => $now->subDays(20),
                'purchase' => 2400.00,
                'current' => 305.00,
                'sell' => 0,
                'commission' => 0,
                'profit_loss' => 0,
                'total' => 2400.00,
                'status' => 'open',
                'type' => 'buy',
                'remaining' => 8,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => $userId,
                'transaction_no' => 'TXN005',
                'symbol' => 'MSFT',
                'stock_name' => 'Microsoft Corp.',
                'no_of_shares' => 15,
                'unit_price' => 250.00,
                'trade_date' => $now->subDays(30),
                'purchase' => 3750.00,
                'current' => 260.00,
                'sell' => 0,
                'commission' => 0,
                'profit_loss' => 0,
                'total' => 3750.00,
                'status' => 'open',
                'type' => 'buy',
                'remaining' => 15,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
