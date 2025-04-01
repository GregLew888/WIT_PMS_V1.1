<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\User;
use App\Models\Setting;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateSettingsRequest;
use App\Http\Requests\UpdateUserStatsRequest;

class AdminController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $request_data = $request->except('_token','password_confirmation','profile_image','role','tel_phone');
        $user = new User();
        foreach($request_data as $key => $value)
        {
            $user->{$key} = $value;
        }

        if ($request['profile_image']) {
            $user->addMedia($request['profile_image'])->toMediaCollection('profile_image');
        } else {
            $user->addMedia(public_path('white/img/default-avatar.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('profile_image');
        }


        $user->assignRole($request->role[0]);
        $user->save();

        return redirect()->back()->withStatus('Client added successfully');
    }

    /**
     * Update user's status
     *
     * @param  \App\Models\User $user
     * @return Response $response
     */
    public function updateStatus(User $user)
    {
        $user->status = true;
        $user->save();

        return redirect()->back()->withStatus($user->name . ' is now approved.');
    }

    /**
     * Update user's password
     *
     * @param  \App\Requests\UpdatePasswordRequest $request
     * @return Response $response
     */
    public function updateUserPassword(UpdatePasswordRequest $request, User $user)
    {
        $user->update(['password' => $request->password]);

        return redirect()->back()->withStatus('Client ' . $user->name. ' password updated');
    }


    /**
     * show the admin settings
     *
     * @param  \App\Models\Setting $model
     * @return Response $response
     */
    public function showSettings(Setting $model)
    {
        // Retrieve the first settings record
        $setting = $model->firstOrFail();

        // Pass the setting model to the view
        return view('profile.setting', [
            'setting' => $setting,
            'company_image' => $setting->company_image_url, // Use the accessor
        ]);
    }

    /**
     * Update origin warehouse user's password
     *
     * @param  \App\Requests\UpdateSettingsRequest $request
     * @param  \App\Models\Setting $model
     * @return Response $response
     */
    public function updateSettings(UpdateSettingsRequest $request, Setting $model)
    {
        $model->first()->update($request->validated());

        return redirect()->back()->withStatus('Site Setting Updated');
    }


    /**
     * Update the Company image
     *
     * @param  \Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function updateImage(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'company_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Retrieve the first settings record
        $setting = Setting::firstOrFail();

        // Delete the existing company image if it exists
        if ($setting->company_image && Storage::disk('public')->exists($setting->company_image)) {
            Storage::disk('public')->delete($setting->company_image);
        }

        // Store the new image in the 'company_images' directory within the 'public' disk
        $path = $request->file('company_image')->store('company_images', 'public');

        // Save the image path to the settings table
        $setting->update(['company_image' => $path]);

        // Generate the public URL for the stored image
        $url = Storage::url($path);

        return response()->json([
            'message' => __('Company image successfully updated.'),
            'url' => $url,
        ]);
    }


    /**
     * Edit the specified users
     *
     * @param  \App\Models\User $user
     * @return Response $response
     */
    public function userEdit(User $user)
    {
        return view('users.edit')->withUser($user);
    }

    /**
     * Update specified user's resource
     *
     * @param  \App\Requests\UpdateUserRequest $request
     * @param  \App\Models\User $model
     * @return Response $response
     */
    public function userUpdate(UpdateUserRequest $request, User $user)
    {
        $request_data = $request->except('_token','_method','tel_phone','profile_image','role');
        // If the user is marked as inactive, log them out
        if ($request->status == '0') {
            $this->invalidateUserSessions($user->id);
        }
        foreach($request_data as $key => $value)
        {
            $user->{$key} = $value;
        }
        $user->save();

        // Handle profile image update
        if ($request->hasFile('profile_image')) {
            // Remove existing profile image if it exists
            if ($user->hasMedia('profile_image')) {
                $user->clearMediaCollection('profile_image');
            }
            // Add the new profile image
            $user->addMedia($request->file('profile_image'))->toMediaCollection('profile_image');
        } else {
            // Set default profile image if no image provided
            if (!$user->hasMedia('profile_image')) {
                $user->addMedia(public_path('white/img/default-avatar.jpg'))
                    ->preservingOriginal()
                    ->toMediaCollection('profile_image');
            }
        }


        $user->syncRoles($request->role);

        return redirect()->back()->withStatus($user->name . ' Client Updated');
    }

    /**
     * Edit the specified users
     *
     * @param  \App\Models\User $user
     * @return Response $response
     */
    public function userEditStats(User $user)
    {
        return view('users.edit-stats')->withUser($user)->withStats($this->stats($user));
    }

    /**
     * Update specified user's resource
     *
     * @param  \App\Requests\UpdateUserStatsRequest $request
     * @param  \App\Models\User $model
     * @return Response $response
     */
    public function statsUpdate(UpdateUserStatsRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect()->back()->withStatus($user->name . ' Client Stats Updated');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back()->withStatus('Client deleted successfully!');
    }

    protected function invalidateUserSessions($userId)
    {
        DB::table('sessions')->where('user_id', $userId)->delete();
    }

}
