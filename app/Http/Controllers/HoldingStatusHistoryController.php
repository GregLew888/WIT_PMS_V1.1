<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeHoldingStatusRequest;
use App\Http\Requests\StoreHoldingStatusHistoryRequest;
use App\Http\Requests\UpdateHoldingStatusHistoryRequest;
use App\Models\HoldingStatusHistory;
use App\Services\HoldingService;
use GuzzleHttp\Psr7\Request;

class HoldingStatusHistoryController extends Controller
{

    protected $holdingService;

    public function __construct(HoldingService $holdingService)
    {
        $this->holdingService = $holdingService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function change(ChangeHoldingStatusRequest $request)
    {

        $holding = $this->holdingService->findById($request->get('holding_id'));

        $statusItem = new HoldingStatusHistory();
        $statusItem->holding_id = $request->get('holding_id');
        $statusItem->new_status = $request->get('new_status');
        $statusItem->old_status = $holding->status;
        $statusItem->user_id = auth()->user()->id;
        $statusItem->save();

        $holding->status = $request->get('new_status');
        $holding->save();
        return redirect()->route('holdings.show', ['holding' => $holding->id])->withStatus('Status Changed Successfully');;
    }

}
