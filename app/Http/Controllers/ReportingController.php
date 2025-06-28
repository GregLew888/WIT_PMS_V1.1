<?php
namespace App\Http\Controllers;

use App\Services\HoldingService;
use App\Services\PriceUpdateService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportingController extends Controller{

    private $userService;
    private $holdingService;
    private $priceService;

    public function __construct(UserService $userService, HoldingService $holdingService, PriceUpdateService $priceService)
    {
        $this->userService = $userService;
        $this->holdingService = $holdingService;
        $this->priceService = $priceService;
    }

    public function RealTimeFeed(Request $request){
        $user = auth()->user();
        return view('widgets.holdings.realtime-overview', ['user' => $user]);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function BreakdownOverview(Request $request){
        $user = auth()->user();
        $marketOverview = $this->priceService->getMarketFeed($user->id);
        $portfolio = $marketOverview['portfolio'];
        return new Response($portfolio);
    }
}
