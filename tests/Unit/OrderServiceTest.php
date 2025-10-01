<?php

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('calculates totals with discount rule', function () {
    $user = User::factory()->create();
    Product::factory()->create(['price' => 150]);
    Product::factory()->create(['price' => 100]);

    $p1 = Product::first();
    $p2 = Product::find(2);

    Cart::create(['user_id' => $user->id, 'product_id' => $p1->id, 'quantity' => 1]);
    Cart::create(['user_id' => $user->id, 'product_id' => $p2->id, 'quantity' => 1]);

    $service = new OrderService();
    $totals = $service->calculateTotals($user->id);

    expect($totals['subtotal'])->toBe(250.0);
    expect($totals['discount'])->toBe(25.0);
    expect($totals['total'])->toBe(225.0);
});


