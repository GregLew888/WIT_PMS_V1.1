<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $userId = 10;
        $data = DB::table('holdings')
            ->select(
                'user_id',
                DB::raw('SUM(no_of_shares * current) - SUM(IFNULL(sell, 0)) AS account_balance'),
                DB::raw('SUM(IFNULL(sell, 0) - (purchase + IFNULL(commission, 0))) AS cash_balance'),
                DB::raw('SUM(purchase) - SUM(IFNULL(sell, 0)) AS outstanding_balance'),
                DB::raw('SUM((no_of_shares * current) - purchase) AS margin_amount')
            )
            ->where('user_id', $userId)
            ->groupBy('user_id')
            ->get()->first();



                    


        return view('dashboard', ['data' => (array)$data]);


    }
}
