<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::prefix("cart")->controller(CartController::class)->middleware(['auth:sanctum', 'role:customer'])->group(function () {
    Route::get('/', 'index');
    Route::post('/items', 'addItem');
    Route::put('/items/{productId}', 'updateItem');
    Route::delete('/items/{productId}', 'removeItem');
    Route::delete('/', 'clear');
});