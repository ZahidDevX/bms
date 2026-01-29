<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::prefix('access-administration')->middleware('guest:web')->group(function () {

});

Route::prefix('access-administration')->middleware('auth:web')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});