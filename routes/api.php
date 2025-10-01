<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout']);

        Route::middleware('role:admin')->group(function () {
            // Admin protected endpoints (manage categories, products, orders) - to be implemented
        });

        Route::middleware('role:customer')->group(function () {
            // Customer endpoints (place orders, manage cart) - to be implemented
        });
    });
});


