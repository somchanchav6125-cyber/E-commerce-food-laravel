<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Google Authentication
    Route::get('auth/google', [GoogleController::class, 'redirect'])
        ->name('auth.google');
});

// Google callback - MUST be outside guest middleware
// Because after login, user is authenticated, not guest anymore
// But we add 'guest' check inside the callback method to avoid redirect loop
Route::get('auth/google/callback', [GoogleController::class, 'callback']);

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
