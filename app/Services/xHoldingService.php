<?php
namespace App\Services;

use App\Http\Requests\Common\PaginatedRequest;
use App\Models\Holding;
use App\Models\HoldingOverview;
use App\Models\HoldingStatusHistory;

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
        $statuses = ['buy', 'sell', 'withdrawal', 'credit', 'cancelled', 'short', 'cover'];
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
                $overview[$symbol]['qty'] = $details[$symbol]['qty'];
                $overview[$symbol]['price'] = floatval($details[$symbol]['price']);
            }else{
                $overview[$symbol]['qty'] = 0;
                $overview[$symbol]['price'] = 0;
            }
        }
        return $overview;
    }

    public function saveOverview($overview, $client_id){
        HoldingOverview::query()->where('user_id', $client_id)->delete();
        $data = [];
        foreach($overview as $symbol => $details){
            $qty = $details['qty'];
            $price = $details['price'];
            HoldingOverview::create([
                'user_id' => $client_id,
                'symbol' => $symbol,
                'qty' => $qty,
                'price' => $price,
            ]);
        }
        return true;
    }

    /**
     *
     *
     *
     * @return void
     */
    public function getSymbols(){
        $query = Holding::query();
        $symbols = $query->select('symbol')->distinct()->get()->keyBy('symbol')->toArray();
        return array_combine(array_keys($symbols), array_keys($symbols));
    }

    public function delete($id){
        HoldingStatusHistory::query()->where('holding_id', $id)->delete();
        Holding::query()->where('id', $id)->delete();
        return true;
    }

    /**
     * Undocumented function
     *
     * @param [type] $holding
     * @return void
     */
    public function formatPnL($holding){
        $types = ['cover', 'credit', 'withdrawal'];
        $arrTypes = array_combine($types, $types);
        if( array_key_exists(strtolower($holding->type), $arrTypes) === true){
            return number_format($holding->profit_loss, 2);
        }

        if(strtolower($holding->type) == 'short'){
            return 'Unrealized';
        }
        if( strtolower($holding->type)  == 'buy'){
            return 'Holding';
        }

        return null;
    }

    public function getClientPnl($user_id){
        $arrTypes = ['cover', 'credit', 'withdrawal'];
        $query = Holding::query();
        $query = $query->where('user_id', $user_id);
        $query = $query->whereIn('type', ['cover', 'credit', 'withdrawal']);
        $query = $query->groupBy('type');
        $query = $query->selectRaw('type, sum(profit_loss) as pnl');
        $queryResult = $query->get()->keyBy('type')->toArray();
        $result = [];
        foreach($arrTypes as $type){
            if(array_key_exists($type, $queryResult) === false){
                $result[$type] = 0;
            }else{
                $result[$type] = $queryResult[$type]['pnl'];
            }
        }
        return $result;
    }
}
