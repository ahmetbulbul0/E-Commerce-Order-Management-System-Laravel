<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout']);

        // Me
        Route::get('me', function () { return response()->json(auth()->user()); });

        Route::middleware('role:admin')->group(function () {
            // Category admin CRUD
            Route::post('categories', [CategoryController::class, 'store']);
            Route::put('categories/{id}', [CategoryController::class, 'update']);
            Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

            // Product admin CRUD
            Route::post('products', [ProductController::class, 'store']);
            Route::put('products/{id}', [ProductController::class, 'update']);
            Route::delete('products/{id}', [ProductController::class, 'destroy']);

            // Orders status update
            Route::put('orders/{id}/status', [OrderController::class, 'updateStatus']);
        });

        Route::middleware('role:customer')->group(function () {
            // Cart
            Route::get('cart', [CartController::class, 'index']);
            Route::post('cart', [CartController::class, 'store']);
            Route::put('cart/{id}', [CartController::class, 'update']);
            Route::delete('cart/{id}', [CartController::class, 'destroy']);

            // Orders
            Route::post('orders', [OrderController::class, 'store'])->middleware('stock.available');
            Route::get('orders', [OrderController::class, 'index']);

            // Payment (mock)
            Route::post('orders/{id}/payment', [PaymentController::class, 'store']);
        });
    });

    // Public endpoints
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
});


