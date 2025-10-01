<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// Customer cart management
Route::prefix("cart")->controller(CartController::class)->middleware(['auth:sanctum', 'role:customer'])->group(function () {
    Route::get('cart', 'index');
    Route::post('cart', 'store');
    Route::put('cart/{id}', 'update');
    Route::delete('cart/{id}', 'destroy');
});
