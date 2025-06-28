<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\AlphaVantageService;

class StockController extends Controller
{
    protected $alphaVantageService;

    public function __construct(AlphaVantageService $alphaVantageService)
    {
        $this->alphaVantageService = $alphaVantageService;
    }

    public function getMonthlyData(Request $request)
    {

        // return $this->alphaVantageService->searchSymbol(request()->q);
        $stats = null;
        $user = auth()->user();    
        
        if ($user->hasRole('client')) {
            // Fetch stats from the users table
            $userStats = [
                'account_balance' => $user->account_balance ?? null,
                'cash_balance' => $user->cash_balance ?? null,
                'outstanding_balance' => $user->outstanding_balance ?? null,
                'margin_amount' => $user->margin_amount ?? null,
            ];
        
            // Check if all values from the users table are null
            $hasUserStats = !is_null($userStats['account_balance']) || 
                            !is_null($userStats['cash_balance']) || 
                            !is_null($userStats['outstanding_balance']) || 
                            !is_null($userStats['margin_amount']);
        
            if ($hasUserStats) {
                // If user table stats are available, use them
                $stats = (object) $userStats;
            } else {
                // Otherwise, calculate from holdings
                $stats = $this->stats($user);
            }
        }
        


        // Step 1: Get the logged-in user
        $user = Auth::user();

        // Step 2: Retrieve the user's recent searches, defaulting to the top 3
        $recentSearches = collect($user->recent_searches)->take(3);

        // Step 3: Check for a new search query in the request
        if (request()->has('q') && request()->q !== '') {
            $newSearch = request()->q;
            $user->addRecentSearch($newSearch); // Add new search to recent searches
            // Add the new search at the beginning, followed by the recent searches
            $symbols = collect([$newSearch])->merge($recentSearches);
        } else {
            // Use only the top 3 recent searches if no new search is provided
            $symbols = $recentSearches;
        }

        // Step 4: Ensure symbols are unique
        $symbols = $symbols->unique();

        // Step 5: Add fallback symbols if there are fewer than 3
        $fallBackSymbols = collect(['AAPL', 'META', 'MSFT']);        

        while ($symbols->count() < 3) {
            $remainingCount = 3 - $symbols->count();
            // Get only the fallback symbols that are not already in $symbols
            $neededSymbols = $fallBackSymbols->diff($symbols)->take($remainingCount);

            $symbols = $symbols->merge($neededSymbols)->unique();
            if ($neededSymbols->isEmpty()) {
                break;
            }
        }

        // Step 6: Limit the final list to exactly 3 symbols and convert to array
        $symbols = $symbols->take(3)->values()->toArray();
        $filter = request()->get('filter', 'day'); // Default to 'day' if no filter is provided
        $oneDayData = $this->alphaVantageService->fetchIntraDaySingleDetails($symbols);
        $oneWeekData = $this->alphaVantageService->getDailyTimeSeries($symbols);
        $oneMonthData = $this->alphaVantageService->getWeeklyTimeSeries($symbols);                        
        $oneYearData = $this->alphaVantageService->getMonthlyTimeSeries($symbols);
    

        $digitalData = $this->alphaVantageService->fetchIntraDayDetails($symbols);
        $digitalDataSingle = $oneWeekData;

        $response = [];

        $symbols = [];
        $x_axis_labels_multi_array = [];        
        $count = 0;        
        foreach($oneDayData as $symbol => $values)
        {
            // dd($oneDayData,$oneWeekData,$symbol, $values,$oneWeekData[$symbol]);
            $x_axis_labels_multi_array[$count]['daily'] = (is_array($values)) ? array_keys($values) : ['No Data found'];
            $x_axis_labels_multi_array[$count]['weekly'] = (is_array($oneWeekData[$symbol])) ? array_keys($oneWeekData[$symbol]) : ['No Data found'];
            $x_axis_labels_multi_array[$count]['monthly'] = (is_array($oneMonthData[$symbol])) ? array_keys($oneMonthData[$symbol]) : ['No Data found'];
            $x_axis_labels_multi_array[$count]['yearly'] = (is_array($oneYearData[$symbol])) ? array_keys($oneYearData[$symbol]) : ['No Data found'];                    
            $symbols[] = $symbol;

            $response['data'. $count]['daily'] = (is_array($values)) ? array_values($values) : ['No Data found'];
            $response['data'. $count]['weekly'] = (is_array($oneWeekData[$symbol])) ? array_values($oneWeekData[$symbol]) : ['No Data found'];
            $response['data'. $count]['monthly'] = (is_array($oneMonthData[$symbol])) ? array_values($oneMonthData[$symbol]) : ['No Data found'];
            $response['data'. $count]['yearly'] = (is_array($oneYearData[$symbol])) ? array_values($oneYearData[$symbol]) : ['No Data found'];                                
            $count++;
        }
        $response['months'] = $x_axis_labels_multi_array;
        $response['symbols'] = $symbols;

        // digital
        $response['digital_keys'] = array_keys($digitalData);
        $response['digital_values'] = array_values($digitalData);


        $response['data'] = (array) $stats;
        
        $response['digital_data'] = $digitalDataSingle;
        
        
        if ($request->expectsJson()) {
            return response()->json($response);
        }
        // dd($response);
        return view('dashboard', $response);
    }

    public function search() 
    {
        $results =  $this->alphaVantageService->searchSymbol(request()->input('query'));                
        // Filter for items with "currency" as "USD"
        $filteredData = array_values(array_filter($results['bestMatches'], function ($item) {
            return isset($item["8. currency"]) && $item["8. currency"] === "USD";
        }));        

        return response()->json(['results' => $filteredData]);
    }
}
