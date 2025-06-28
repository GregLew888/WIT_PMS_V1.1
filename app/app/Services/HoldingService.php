<?php
namespace App\Services;

use App\Http\Requests\Common\PaginatedRequest;
use App\Models\Holding;
use App\Models\HoldingOverview;

class HoldingService {

    public function search( PaginatedRequest $request ){
        $query = Holding::query();
        if($request->client_id ){
            $query = $query->with('client');
            $query = $query->where('user_id', $request->client_id);
        }
        if(!empty($request->keyword)){
            $query = $query->where('symbol', 'like', '%'.$request->keyword.'%')
            ->orWhere('stock_name', 'like', '%'.$request->keyword.'%')->orWhere('transaction_no', 'like', '%'.$request->keyword.'%');
        }
        if(!empty($request->type)){
            $query = $query->where('type', $request->type);
        }
        $query = $query->orderby('created_at', 'desc')->orderBy('trade_date', 'desc');
        return $query->paginate($request->per_page);
    }

    public function findById($id) : Holding{
        $query = Holding::find($id);
        return $query;
    }

    /**
     * Undocumented function
     *
     * @param int $userId
     * @return void
     */
    public function recentUserHoldings( $userId ){

        $request = new PaginatedRequest();
        $request->client_id = $userId;
        $request->page = 0;
        $request->per_page = 10;
        return $this->search($request);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getTransactionTypes(){
        $statuses = ['buy', 'sell', 'withdrawal', 'credit', 'cancelled', 'short'];
        sort($statuses);
        return $statuses;
    }

    public function getOverview($client_id){
        $query = Holding::query();
        $query = $query->where('user_id', $client_id)->groupBy('symbol');
        $result =  $query->select('symbol')->distinct()->get()->keyBy('symbol')->toArray();
        $details = HoldingOverview::query()->where('user_id', $client_id)->get()->keyBy('symbol')->toArray();
        $overview = [];
        ksort($result);
        foreach($result as $symbol => $value){
            if(array_key_exists($symbol, $details) === true){
                $overview[$symbol] = $details[$symbol]['qty'];
            }else{
                $overview[$symbol] = 0;
            }
        }
        return $overview;
    }

    public function saveOverview($overview, $client_id){
        HoldingOverview::query()->where('user_id', $client_id)->delete();
        $data = [];
        foreach($overview as $symbol => $value){
            HoldingOverview::create([
                'user_id' => $client_id,
                'symbol' => $symbol,
                'qty' => $value
            ]);
        }
        return true;
    }
}
