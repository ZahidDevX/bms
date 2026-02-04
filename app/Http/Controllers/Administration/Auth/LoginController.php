<?php

namespace App\Http\Controllers\Administration\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function create()
    {
        return Inertia::render('Administration/Auth/Login');
    }

    /**
     * Handle a login request.
     */
    public function store(Request $request)
    {
        
    }
}
