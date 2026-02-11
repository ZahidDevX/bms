<?php

namespace App\Http\Controllers\Administration\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Administration\Auth\LoginRequest;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return Inertia::render('Administration/Auth/Login', [
            'bgImage' => asset('assets/images/administration_login_page_bg.jpg'),
        ]);
    }

    /**
     * Handle a login request.
     */
    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();

        $authenticated = Auth::guard('web')->attempt([
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ], $validatedData['remember']);

        if ($authenticated) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard.index'));
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle a logout request.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login.form');
    }
}
