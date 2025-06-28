<?php

<<<<<<< HEAD
use App\Models\User;
=======
>>>>>>> d00f9ff (Updated PMS backup from external hard drive)
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HoldingController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

<<<<<<< HEAD
//Auth::login(User::find(20)); // Admin
//Auth::login(User::find(21)); // Samuel Testing


=======
>>>>>>> d00f9ff (Updated PMS backup from external hard drive)
Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');

Auth::routes(['register' => false]);

Route::get('/test', function () {

        // Run migrate:fresh and seed
            // Artisan::call("storage:link");
            Artisan::call("migrate");

        // Artisan::call('route:cache');
        // Artisan::call('config:cache');
        // Artisan::call('view:cache');
        // Artisan::call('optimize');

        return response()->json(['message' => 'Database has been reset and seeded successfully!']);

});
Route::get('/clear', function () {
    Artisan::call('optimize:clear');

        return response()->json(['message' => 'Clear!']);

});
// Route in web.php
Route::post('/clear-session', function (Illuminate\Http\Request $request) {
    session()->forget($request->input('key', 'status'));
    return response()->json(['success' => true]);
})->name('clear.session');


Route::group(['middleware' => ['guest']], function () {
    Route::get('/password/reset', 'App\Http\Controllers\StockController@getMonthlyData')->name('home');
});

Route::group(['middleware' => ['auth', 'change-password']], function () {
    Route::get('/home', 'App\Http\Controllers\StockController@getMonthlyData')->name('home');
    Route::get('/home2', 'App\Http\Controllers\StockController@Dashboard')->name('home2');

    Route::get('/transaction/realtime', 'App\Http\Controllers\HoldingController@RealTimeDashboard')->name('transaction-realtime');
    Route::get('/reporting/realtime', 'App\Http\Controllers\ReportingController@RealTimeFeed')->name('reporting-realtime');
    Route::get('/reporting/breakdown', 'App\Http\Controllers\ReportingController@BreakdownOverview')->name('reporting-breakdown');

    //--------- Routes accessible by all roles -------------
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit'])->withoutMiddleware( 'change-password');
	Route::post('profile/image', ['as' => 'profile.image', 'uses' => 'App\Http\Controllers\ProfileController@updateImage']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('stock/{symbol}', ['as' => 'stock', 'uses' => 'App\Http\Controllers\StockController@getMonthlyData']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password'])->withoutMiddleware( 'change-password');;
    Route::resource('holdings', HoldingController::class)->only('index');
    Route::get('search','StockController@search');


    Route::resource('tickets', TicketController::class)->only('create', 'store')->middleware('role:user');

    Route::resource('tickets', TicketController::class)->only('index')->middleware('role:admin|user');
    Route::resource('replies', ReplyController::class)->only('store')->middleware('role:admin|user');

    //--------- Routes only accessible by admin -------------
    Route::middleware(['role:admin'])->group(function () {
        Route::get('users/{user}/approve', ['as' => 'users.approve', 'uses' => 'App\Http\Controllers\AdminController@updateStatus']);
        Route::put('users/{user}/password', ['as' => 'users.password', 'uses' => 'App\Http\Controllers\AdminController@updateUserPassword']);
        Route::delete('users/{user}', ['as' => 'users.delete', 'uses' => 'App\Http\Controllers\UserController@destroy']);
        Route::get('settings', ['as' => 'settings', 'uses' => 'App\Http\Controllers\AdminController@showSettings']);
        Route::put('settings', ['as' => 'settings.update', 'uses' => 'App\Http\Controllers\AdminController@updateSettings']);
	    Route::post('company/image', ['as' => 'company.image', 'uses' => 'App\Http\Controllers\AdminController@updateImage']);
	    Route::get('users', ['as' => 'users.index', 'uses' => 'App\Http\Controllers\UserController@index']);
	    Route::post('users', ['as' => 'users.store', 'uses' => 'App\Http\Controllers\AdminController@store']);
	    Route::get('users/create', ['as' => 'users.create', 'uses' => 'App\Http\Controllers\AdminController@create']);
	    Route::get('users/active', ['as' => 'users.active.index', 'uses' => 'App\Http\Controllers\UserController@activeIndex']);
	    Route::get('users/{id}/view', ['as' => 'users.view', 'uses' => 'App\Http\Controllers\UserController@viewIndex']);
        Route::get('users/{user}/edit', ['as' => 'users.edit', 'uses' => 'App\Http\Controllers\AdminController@userEdit']);
        Route::put('users/{user}', ['as' => 'users.update', 'uses' => 'App\Http\Controllers\AdminController@userUpdate']);
        Route::get('users/{user}/edit-stats', ['as' => 'users.edit-stats', 'uses' => 'App\Http\Controllers\AdminController@userEditStats']);
        Route::put('users/{user}/stats', ['as' => 'users.update-stats', 'uses' => 'App\Http\Controllers\AdminController@statsUpdate']);

        Route::post('transaction/{id}/change', ['as'=>'transaction.change', 'uses' => 'App\Http\Controllers\HoldingController@change']);
        Route::get('transaction/{id}/lookup', ['as'=>'transaction.lookup', 'uses' => 'App\Http\Controllers\HoldingController@Lookup']);
        Route::resource('holdings', HoldingController::class)->only('create', 'store', 'edit', 'show', 'destroy');
        Route::resource('tickets', TicketController::class)->only('destroy');

        Route::post('holding_status/change', ['as'=>'holding_status.change', 'uses' => 'App\Http\Controllers\HoldingStatusHistoryController@change']);
        Route::get('holdings/{user}/change-overview', ['as'=>'holdings.change-overview', 'uses' => 'App\Http\Controllers\HoldingController@changeOverview']);
        Route::post('holdings/{user}/do-change-overview', ['as'=>'holdings.do-change-overview', 'uses' => 'App\Http\Controllers\HoldingController@doChangeOverview']);

        Route::get('lookup/clients', ['as' => 'lookup.clients', 'uses' => 'App\Http\Controllers\LookupController@clients']);

    });


});


// Password reset link request routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

// Password reset routes
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('password/reset', [ResetPasswordController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');

// Password confirmation routes
Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])
    ->middleware('guest')
    ->name('password.confirm');

Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm'])
    ->middleware('guest');

