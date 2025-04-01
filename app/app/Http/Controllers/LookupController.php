<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Enums\Roles; // Add this line to import the Roles class
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class LookupController extends Controller{

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function clients(Request $request){
        $data = [];
        $query = User::whereHas('roles', function($q){
            $q->where('name', Roles::CLIENT()->value);
        })->active();
        $search = $request->q;
        if(!empty($search)){
            $query = $query->where('name','LIKE',"%$search%")->orWhere('email','LIKE',"%$search%")->orWhere('phone_number','LIKE',"%$search%");
        }
        $query->orderBy('name','asc')->orderBy('email','asc');
        $clients = $query->paginate(20);
        foreach($clients  as $id => $client){
            $data[] = ['id' => $client->id, 'name' => $client->name,
            'email' => $client->email, 'phone_number' => $client->phone_number];
        }
        return response()->json($data);
    }


}

