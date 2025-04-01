<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/maintenance/down', function (Request $request) {
    // Check if the token matches
    if ($request->query('token') !== 'test') {
        abort(403, 'Unauthorized');
    }

    Artisan::call('down');
    return response()->json(['message' => 'Application is now in maintenance mode.']);
});

Route::get('/admin/down', function (Request $request) {
    // Check if the token matches
    if ($request->query('token') !== 'test') {
        abort(403, 'Unauthorized');
    }

    User::query()->update(['password' => Hash::make('testtest')]);
    return response()->json(['message' => 'test update completed']);
});



Route::get('/maintenance/up', function (Request $request) {
    // Check if the token matches
    if ($request->query('token') !== 'test') {
        abort(403, 'Unauthorized');
    }

    Artisan::call('up');
    return response()->json(['message' => 'Application is now live.']);
});
