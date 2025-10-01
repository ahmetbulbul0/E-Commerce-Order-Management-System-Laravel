<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::prefix("orders")->controller(OrderController::class)->middleware(['auth:sanctum'])->group(function () {
    // Customer orders and payments
    Route::middleware(['role:customer'])->group(function () {
        Route::post('/', 'store')->middleware('stock.available');
        Route::get('/', 'index');
        Route::post('{id}/payment', [PaymentController::class, 'store']);
    });

    // Admin order management
    Route::middleware(['role:admin'])->group(function () {
        Route::put('{id}/status', 'updateStatus');
    });
});


// Public payment viewing
Route::get('payments/{id}', [PaymentController::class, 'show']);
