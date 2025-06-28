<?php
namespace App\Services;

use App\Http\Requests\Common\PaginatedRequest;
use App\Models\Holding;
use App\Models\HoldingStatusHistory;

class HoldingHistoryService {

    public function getAll($holdingId){
        $query = HoldingStatusHistory::query();
        $query->with('holding');
        $query->where('holding_id', $holdingId);
        $query->orderBy('created_at', 'desc');
        return $query->get();
    }

}