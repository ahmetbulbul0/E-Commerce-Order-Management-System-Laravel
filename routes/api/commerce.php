<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Customer cart and orders
Route::middleware(['auth:sanctum', 'role:customer'])->group(function () {
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart', [CartController::class, 'store']);
    Route::put('cart/{id}', [CartController::class, 'update']);
    Route::delete('cart/{id}', [CartController::class, 'destroy']);

    Route::post('orders', [OrderController::class, 'store'])->middleware('stock.available');
    Route::get('orders', [OrderController::class, 'index']);

    Route::post('orders/{id}/payment', [PaymentController::class, 'store']);
});

// Admin order management
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::put('orders/{id}/status', [OrderController::class, 'updateStatus']);
});


