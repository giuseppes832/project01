<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

    public function login() {
        return view("components.login");
    }


    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        Log::info('Login attempt.', ['email' => \request()->email]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                Log::info('Admin login.', ['email' => \request()->email]);
                return redirect()->intended('apps/app');
            } else if (Auth::user()->isOwner()) {
                Log::info('Owner login.', ['email' => \request()->email]);
                return redirect()->intended('apps/owner-app');
            } else if (Auth::user()->isInvitedUser()) {
                Log::info('User login.', ['email' => \request()->email]);
                return redirect()->intended('my-invites');
            } else {
                // Non possibile
                return redirect()->intended('dashboard');
            }


        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout() {

        $email = Auth::user()->email;

        if (Auth::user()->isAdmin()) {
            Log::info('Admin try logout.', ['email' => $email]);
            Auth::logout();
            Log::info('Admin logout.', ['email' => $email]);
        } else if (Auth::user()->isOwner()) {
            Log::info('Owner try logout.', ['email' => $email]);
            Auth::logout();
            Log::info('Owner logout.', ['email' => $email]);
        } else if (Auth::user()->isInvitedUser()) {
            Log::info('User try logout.', ['email' => $email]);
            Auth::logout();
            Log::info('User logout.', ['email' => $email]);
        } else {
            // Non possibile
        }

        return redirect("login");
    }

}
