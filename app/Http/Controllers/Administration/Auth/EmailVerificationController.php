<?php

namespace App\Http\Controllers\Administration\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    /**
     * Show Verification Notice
     */
    public function showNotice()
    {
        return Inertia::render('Administration/Auth/EmailVerification/VerificationNotice');
    }

    /**
     * Verify Email
     */

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->intended(route('dashboard.index'));
    }

    /**
     * Send Verification Notice
     */
    public function sendNotice(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'Verification link sent!');
    }
}
