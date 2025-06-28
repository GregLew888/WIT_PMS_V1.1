<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Container;
use Illuminate\Http\Request;
use App\Http\Requests\StoreContainerRequest;
use App\Http\Requests\UpdateContainerRequest;

class ContainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Container $model)
    {
        
        $containers =  $model->withSum('shipments', 'cbm')->withCount('shipments')->with('shipments.customer')->get();

        return view('containers.index', ['containers' => $containers, 'containersJson' => $containers->toJson(JSON_PRETTY_PRINT)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('containers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContainerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContainerRequest $request)
    {
        Container::create($request->validated());

        return redirect()->back()->withStatus('Container added successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContainerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function shipmentsStore(Request $request, Container $container)
    {
        Shipment::whereIn('id', explode(',', $request->shipments[0]))->update(['parent_id' => $container->id, 'shipping_type' => 'App\Models\Container', 'status' => $container->status]);

        return redirect()->back()->withStatus('Shipments added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Container  $container
     * @return \Illuminate\Http\Response
     */
    public function show(Container $container)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Container  $container
     * @return \Illuminate\Http\Response
     */
    public function edit(Container $container)
    {
        return view('containers.edit')->withContainer($container->withCount('shipments')->withSum('shipments', 'cbm')->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Container  $container
     * @return \Illuminate\Http\Response
     */
    public function ShipmentsEdit(Container $container)
    {
       $shipments = Shipment::where('freight_type', 'Sea')->whereNull('parent_id')->get();

        return view('containers.ShipmentEdit', ['shipments' => $shipments, 'shipmentsJson' => $shipments->toJson(JSON_PRETTY_PRINT), 'container' => $container]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContainerRequest  $request
     * @param  \App\Models\Container  $container
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContainerRequest $request, Container $container)
    {
        $container->update($request->validated());

        $container->shipments()->update(['status' => $request->status]);

        return redirect()->route('containers.index')->withStatus('Container updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Container  $container
     * @return \Illuminate\Http\Response
     */
    public function destroy(Container $container)
    {
        //
    }
}
