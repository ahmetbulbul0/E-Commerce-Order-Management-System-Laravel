<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix("products")->controller(ProductController::class)->group(function () {
    // Public product endpoints
    Route::get('/', 'index');
    Route::get('{id}', 'show');

    // Admin product management
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::post('/', 'store');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'destroy');
    });
});
