<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTicketRequest;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Ticket $model)
    {
        $user = auth()->user();
        
        $tickets = $user->hasRole('user') ? $user->tickets()->with('customer', 'replies.user')->get() : $model->with('customer', 'replies.user')->get();

        return view('tickets.index', ['tickets' => $tickets, 'ticketsJson' => $tickets->toJson(JSON_PRETTY_PRINT)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create($request->validated() + ['user_id' => auth()->id()]);

        if($request['files']){
            foreach ($request['files'] as $file) {
                $ticket->addMedia($file)->toMediaCollection('files');
            }
        }

        return back()->withStatus('Ticket Posted');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return back()->withStatus('ticket deleted successfully!');
    }
}
