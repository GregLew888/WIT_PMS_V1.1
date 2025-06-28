<?php
namespace App\Services;

use App\Models\SymbolPrice;

class PriceUpdateService {

    private $holdingService;
    private $alphaVantageService;

    public function __construct(HoldingService $holdingService, AlphaVantageService $alphaVantageService)
    {
        $this->holdingService = $holdingService;
        $this->alphaVantageService = $alphaVantageService;
    }

    public function perform(){
        $symbols = $this->holdingService->getSymbols();

        $prices = $this->alphaVantageService->getRealtimeBulkQuotes($symbols);
        foreach($prices as $symbol => $price){
            SymbolPrice::query()->where('symbol', $symbol)->delete();
            $entity = new SymbolPrice();
            $entity->symbol = $symbol;
            $entity->low = empty($price['low']) ? 0 : $price['low'];
            $entity->high = empty($price['high']) ? 0 : $price['high'];
            $entity->open = empty($price['open']) ? 0 : $price['open'];
            $entity->close = empty($price['close']) ? 0 : $price['close'];
            $entity->previous_close = empty($price['previous_close']) ? 0 : $price['previous_close'];
            $entity->pull_at = $price['timestamp'];
            $entity->save();
        }
    }

    public function getMarketFeed($client_id){
        $overview = $this->holdingService->getOverview($client_id);
        $breakdown = $this->holdingService->getClientPnl($client_id);
        /**
         *
         * Remove 0 Qty symbols
         */
        $symbols = [];

        foreach($overview as $symbol => $details ){
            $qty = $details['qty'];
            if( $qty != 0 ){
                $symbols[$symbol] = $qty;
            }
        }
        $prices = SymbolPrice::query()->whereIn('symbol', array_keys($symbols))->get()->keyBy('symbol')->toArray();
        $portfolio = [];
        $total = 0;
        foreach($symbols as $symbol => $qty){
            $item = [];
            $item['qty'] = $qty;
            $item['symbol'] = $symbol;
            $item['has_error'] = true;
            $item['price_message'] = null;
            $price = 0;

            if(array_key_exists($symbol, $overview)){
                $price = $overview[$symbol]['price'];
                $item['has_error'] = false;
            }
            if(array_key_exists($symbol, $prices)){
                $price = $prices[$symbol]['close'];
                if(empty($price) || floatval($price) == 0){
                    $price = $prices[$symbol]['previous_close'];
                }
                $item['has_error'] = false;
            }
            $item['price_message'] = $item['has_error'] ? 'no price found for this symbol': null;

            $item['price'] = $price;
            $item['total'] = $qty * $price;

            $total += $item['total'];
            $portfolio[$symbol] = $item;
        }

        $breakDownTotal = array_sum($breakdown);
        $accountBalance = $total + $breakDownTotal;
        $portfolio = ["portfolio" => $portfolio, 'total' => $accountBalance, 'invested' => $total];
        return array_merge($portfolio, $breakdown);
    }


    private function deleteSymbolPrice($symbol){
        SymbolPrice::query()->where('symbol', $symbol)->delete();
    }
}
