<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\User;
use App\Models\Setting;
use App\Models\Holding;
use App\Http\Requests\StoreHoldingRequest;
use App\Http\Requests\UpdateHoldingRequest;
use App\Http\Requests\Common\PaginatedRequest;
use App\Services\HoldingService;
use App\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;

class HoldingController extends Controller
{
    private $holdingService;
    private $userService;

    public function __construct(HoldingService $holdingService, UserService $userService)
    {
        $this->holdingService = $holdingService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FormRequest $request)
    {
        $user = auth()->user();
        $request = new PaginatedRequest();
        $request->client_id = request('client_id');
        $request->keyword = request('keyword');
        $request->type = request('type');
        $isAdminUser = true;
        if($user->hasRole(Roles::ADMIN()->value) === false){
            $request->client_id = $user->id;
            $isAdminUser = false;
        }
        $holdings = $this->holdingService->search($request);
        $client = null;
        $clientSelected = false;
        if(!empty($request->client_id)){
            $client = $this->userService->findById($request->client_id);
            $clientSelected = true;
        }
        if($isAdminUser == false){
            return view('holdings.client', ['holdings' => $holdings, 'client' => $client, 'clientSelected' => $clientSelected]);
        }
        return view('holdings.index', ['holdings' => $holdings, 'client' => $client, 'clientSelected' => $clientSelected]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('holdings.create', ['customers' => User::role('client')->active()->get(), 'setting' => Setting::first()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHoldingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHoldingRequest $request)
    {
        $data = $request->all();
        $holding = Holding::create($data += [
            'current' => $data['unit_price'],
            'status' => 'Pending',
            'type' => $data['transaction_type'],
            'total' => $data['purchase'],
            'debit' => $data['purchase'],
            'remaining' => $data['no_of_shares']
        ]);

        return redirect()->route('holdings.show', ['holding' => $holding])->withStatus('Holding added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Holding  $holding
     * @return \Illuminate\Http\Response
     */
    public function show($holdingId)
    {
        $holding = $this->holdingService->findById($holdingId);
        return view('holdings.show', ['holding' => $holding]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Holding  $holding
     * @return \Illuminate\Http\Response
     */
    public function edit(Holding $holding)
    {
        return view('holdings.edit', ['holding' => $holding]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHoldingRequest  $request
     * @param  \App\Models\Holding  $holding
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHoldingRequest $request, Holding $holding)
    {
        $data = $request->validated();

        $data += [
            'status' => 'Credit',
            'type' => 'Sell',
            'remaining' => $holding->remaining - $request->no_of_shares,
            'sell_after_commission' => $request->total,
            'debit' => 0,
        ] + $holding->toArray();

        $holding->update(['remaining' => $data['remaining']]);

        Holding::create($data);

        return redirect()->route('holdings.index')->withStatus('Shares updated successfully!');
    }

    public function changeOverview($user_id){
        $user = $this->userService->findById($user_id);
        $overview = $this->holdingService->getOverview($user_id);
        return view('holdings.change_overview', ['overview' => $overview, 'user' => $user]);
    }

    public function doChangeOverview(FormRequest $request){
        $data = request()->all();
        $this->holdingService->saveOverview($data['overview'], $data['client_id']);
        return redirect()->route('holdings.change-overview', ['user'=> $data['client_id']])->withStatus('Overview Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Holding  $holding
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holding $holding)
    {
        //
    }
}
