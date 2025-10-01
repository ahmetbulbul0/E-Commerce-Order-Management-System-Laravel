<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix("categories")->controller(CategoryController::class)->group(function () {
    // Public category endpoints
    Route::get('/', 'index');

    // Admin category management
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::post('/', 'store');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'destroy');
    });
});
