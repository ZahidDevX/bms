<?php

use App\Http\Controllers\Administration\Auth\EmailVerificationController;
use Inertia\Inertia;
use App\Http\Controllers\Hello;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Administration\Auth\LoginController;
use App\Http\Controllers\Administration\Auth\PasswordResetController;
use App\Http\Controllers\Administration\Dashboard\DashboardController;

Route::prefix('access-administration')->group(function () {
    // Guest Routes
    Route::middleware('guest:web')->group(function () {
        // Login Routes
        Route::prefix('auth')
            ->name('auth.login.')
            ->controller(LoginController::class)
            ->group(function () {
                Route::get('login', 'showLoginForm')->name('form');
                Route::post('login', 'login')->name('process');
            });

        // Password Reset Routes
        Route::prefix('password')
            ->name('password.')
            ->controller(PasswordResetController::class)
            ->group(function () {
                Route::get('request', 'showRequestForm')->name('request.form');
                Route::post('request', 'sendResetLink')->name('request.send');
                Route::get('reset/{token}', 'showResetForm')->name('reset');
                Route::post('reset', 'resetPassword')->name('reset.process');
            });

    });

    // Authenticated Routes
    Route::middleware(['auth:web'])->group(function () {
        // Email Verification Routes
        Route::prefix('email')->controller(EmailVerificationController::class)->name('verification.')->group(function () {
            Route::get('verify', 'showNotice')->name('notice');
            Route::get('verify/{id}/{hash}', 'verify')->name('verify')->middleware('signed');
            Route::get('/verification-notification', 'sendNotice')->name('send')->middleware('throttle:6,1');
        });
    });

    // Authenticated & Verified Routes
    Route::middleware(['auth:web', 'verified'])->group(function () {
        // Dashboard Routes
        Route::prefix('dashboard')->controller(DashboardController::class)->name('dashboard.')->group(function () {
            Route::get('/', 'index')->name('index');
        });

        // Logout Route
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });
});