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

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display inactive users listing.
     */
    public function index(User $model)
    {
        $users = $model->where('status', false)->get();
        return view('users.index', compact('users'));
    }

    /**
     * Display active users listing with pagination and search.
     */
    public function activeIndex(PaginatedRequest $request)
    {
        $users = $this->userService->search($request);
        return view('users.activeIndex', compact('users', 'request'));
    }

    /**
     * Display details for a single user.
     */
    public function viewIndex($userId)
    {
        $user = $this->userService->findById($userId);
        return view('users.view', compact('user'));
    }

    /**
     * Update a specific user record.
     */
    public function update(RecordRequest $request, $id)
    {
        $this->userService->update($request->validated(), $id);
        return redirect()->route('users.view', $id)
                         ->with('status', 'Client record updated successfully.');
    }

    /**
     * Update user's password securely.
     */
    public function password(RecordRequest $request, $id)
    {
        $this->userService->updatePassword($request->validated(), $id);
        return redirect()->route('users.view', $id)
                         ->with('status', 'Password updated successfully.');
    }

    /**
     * Delete user and associated data.
     */
    public function destroy(User $user)
    {
        Holding::where('user_id', $user->id)->delete();
        Media::where('model_id', $user->id)->delete();
        $user->delete();

        return back()->with('status', 'Client deleted successfully.');
    }
}