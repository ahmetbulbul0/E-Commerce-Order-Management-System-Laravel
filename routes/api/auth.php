<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    // Public auth endpoints
    Route::post('register', 'register');
    Route::post('login', 'login');

    // Protected auth endpoints
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', 'logout');
        Route::get('me', 'me');
    });
});
