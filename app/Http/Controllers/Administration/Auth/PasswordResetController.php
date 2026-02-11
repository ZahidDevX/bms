<?php

namespace App\Http\Controllers\Administration\Auth;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetController extends Controller
{
    /**
     * Show the form to request a password reset link.
     */
    public function showRequestForm()
    {
        return Inertia::render('Administration/Auth/Password/PasswordResetRequest');
    }

    /**
     * Handle the incoming password reset link request.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::ResetLinkSent
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show the form to reset the password.
     */
    public function showResetForm(Request $request, $token)
    {
        return Inertia::render('Administration/Auth/Password/PasswordResetForm', [
            'token' => $token,
            'email' => $request->string('email')
        ]);
    }

    /**
     * Handle the incoming password reset request.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PasswordReset
            ? redirect()->route('auth.login.form')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
