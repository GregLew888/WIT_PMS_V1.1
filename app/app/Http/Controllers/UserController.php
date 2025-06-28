<?php

namespace App\Http\Controllers;

use App\Http\Requests\Common\PaginatedRequest;
use App\Http\Requests\Common\RecordRequest;
use App\Models\Holding;
use App\Models\User;
use App\Services\UserService;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserController extends Controller
{
    private $userService;
    public function __construct( UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->where('status', false)->get()]);
    }


    /**
     * Display a listing of the active users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function activeIndex(PaginatedRequest $request)
    {
        $users = $this->userService->search( $request );
        return view('users.activeIndex', ['users' => $users, 'request' => $request]);
    }

    /**
     * Undocumented function
     *
     * @param User $model
     * @return void
     */
    public function viewIndex($userId)
    {
        $user = $this->userService->findById($userId);
        return view('users.view', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Holding::where('user_id',$user->id)->delete();
        Media::where('model_id',$user->id)->delete();
        $user->delete();
        return back()->withStatus('Client deleted successfully!');
    }
}
