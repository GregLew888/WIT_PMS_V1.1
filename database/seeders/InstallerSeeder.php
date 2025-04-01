<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Holding;
use App\Models\HoldingStatusHistory;
use App\Enums\Roles;
use App\Services\HoldingService;
use Symfony\Component\VarDumper\VarDumper;

class InstallerSeeder extends Seeder{
    private $faker;
    private $holdingService;

    public function __construct(HoldingService $holdingService){
        $this->faker = Faker::create();
        $this->faker->seed( 20240510 );
        $this->holdingService = $holdingService;
    }

    public function run(){
        $userEmails = [];
        for($counter = 0; $counter < 50; $counter++){
            $email = "clientx+{$counter}@example.com";
            $user = $this->createUser( $email, $this->faker->name() );
        }
    }

    private function createUser($email, $name){
        $user = User::where("email" , $email)->first();
        if($user == null){
            $phoneNumber = "+92322" . $this->faker->randomNumber(6);
            $user = User::create(
                [
                    'name' => $name,
                    'email' => $email,
                    'email_verified_at' => now(),
                    'password' => 'secret',
                    'username' => $email,
                    'phone_number' => $phoneNumber,
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            );
            $user->assignRole(Roles::CLIENT()->value);
            $user->addMedia(public_path('white/img/default-avatar.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('profile_image');
            $user->getMedia('profile_image')->first()->copy($user, 'passport_photo');
        }
        $this->createHolding($user);
        return $user;
    }

    private function createHolding(User $user){
        $now = Carbon::now();

        $threeMonthsAgo = Carbon::now()->subMonths(3);
        for($counter = 0; $counter <= 20; $counter++){
            $holding = $this->generateHolding($user, $threeMonthsAgo);
            $record = Holding::create($holding);
            $this->processHistory($record);
        }

        $twoMonthsAgo = Carbon::now()->subMonths(2);
        for($counter = 0; $counter <= 20; $counter++){
            $holding = $this->generateHolding($user, $twoMonthsAgo);
            $record = Holding::create($holding);
            $this->processHistory($record);
        }

        $lastMonth = Carbon::now()->subMonths(1);
        for($counter = 0; $counter <= 20; $counter++){
            $holding = $this->generateHolding($user, $lastMonth);
            $record = Holding::create($holding);
            $this->processHistory($record);
        }
        $thisMonth = Carbon::now();
        for($counter = 0; $counter <= 20; $counter++){
            $holding = $this->generateHolding($user, $thisMonth);
            $record = Holding::create($holding);
            $this->processHistory($record);
        }

    }

    private function processHistory($holding){
        $new_status = $this->faker->randomElement(['paid', 'cancelled']);
        $historyItem = new HoldingStatusHistory();
        $historyItem->holding_id = $holding->id;
        $historyItem->user_id = 1;
        $historyItem->new_status = $new_status;
        $historyItem->old_status = $holding->status;
        $historyItem->save();

        $holding->status = $new_status;
        $holding->save();
    }

    private function generateHolding(User $user, Carbon $timestamp){
        $trade_date = $this->faker->dateTimeBetween($timestamp->startOfMonth(), $timestamp->endOfMonth());
        $txNo = "TX-{$user->user_id}/{$timestamp->format('Ym')}-{$this->faker->randomNumber(6)}";
        $shares = $this->faker->randomElement([100, 250, 500, 1000]);
        $unit_price = $this->faker->randomNumber(3, true);

        $tickers = [
            "AAPL" => "Apple Inc.",
            "MSFT" => "Microsoft Corporation",
            "GOOGL" => "Alphabet Inc.",
            "AMZN" => "Amazon.com Inc.",
            "TSLA" => "Tesla Inc.",
            "FB" => "Facebook Inc.",
            "NVDA" => "NVIDIA Corporation",
            "PYPL" => "PayPal Holdings Inc.",
            "INTC" => "Intel Corporation",
            "CSCO" => "Cisco Systems Inc.",
            "NFLX" => "Netflix Inc.",
            "ADBE" => "Adobe Inc.",
            "CMCSA" => "Comcast Corporation",
            "PEP" => "PepsiCo Inc.",
            "COST" => "Costco Wholesale Corporation",
            "TMUS" => "T-Mobile US Inc.",
            "AVGO" => "Broadcom Inc.",
            "TXN" => "Texas Instruments Incorporated",
        ];
        $symbol = $this->faker->randomElement(array_keys($tickers));
        $types = $this->holdingService->getTransactionTypes();

        return [
            'user_id' => $user->id,
            'transaction_no' => $txNo,
            'symbol' => $symbol,
            'stock_name' => $tickers[$symbol],
            'no_of_shares' => $shares,
            'unit_price' => $unit_price,
            'trade_date' => $trade_date,
            'purchase' => 1500.00,
            'current' => 160.00,
            'sell' => 0,
            'commission' => 0,
            'profit_loss' => 0,
            'total' => $shares * $unit_price,
            'status' => 'pending',
            'type' => $this->faker->randomElement($types),
            'remaining' => 10,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ];
    }

}
