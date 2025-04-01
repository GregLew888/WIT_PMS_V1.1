<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
    return view('profile.edit')->with('changePassword', request()->query('change-password', auth()->user()->first_login)) ;
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }
    
    /**
     * Update the profile image
     *
     * @param  \Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateImage(Request $request)
    {
        $user = auth()->user();
        
        // Validate the uploaded file
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Update the user's profile image
        $user->updateProfileImage($request->file('profile_image'));

        return response()->json([
            'message' => 'Profile image updated successfully!',
            'profile_image_url' => $user->getProfileImageUrl(),
        ]);
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => $request->get('password'), 'first_login' => false]);

        return redirect()->route('profile.edit')->withPasswordStatus(__('Password successfully updated.'));
    }
}
