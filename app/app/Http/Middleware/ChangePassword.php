<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ChangePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        

        // Check if user is logged in and it's their first login
        if ($user && $user->first_login) {
            // Redirect to profile page with query param 'first_login=true'
            return redirect()->route('profile.edit', ['change-password' => true])->withPasswordStatus( 'Please update the password first.');
        }

        return $next($request);
    }
}
