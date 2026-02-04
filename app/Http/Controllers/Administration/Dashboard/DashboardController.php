<?php

namespace App\Http\Controllers\Administration\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard view.
     */
    public function index()
    {
        return Inertia::render('Administration/Dashboard/DashboardIndex');
    }
}
