<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    require __DIR__.'/api/auth.php';
    require __DIR__.'/api/category.php';
    require __DIR__.'/api/product.php';
    require __DIR__.'/api/cart.php';
    require __DIR__.'/api/order.php';
});