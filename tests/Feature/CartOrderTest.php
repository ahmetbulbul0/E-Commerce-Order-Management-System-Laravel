<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('updates cart and places order', function () {
    $customer = User::factory()->create(['password' => 'password']);
    $token = $customer->createToken('t')->plainTextToken;

    $product = Product::factory()->create(['stock' => 5, 'price' => 20]);

    // add to cart
    $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson('/api/v1/cart', [
            'product_id' => $product->id,
            'quantity' => 2,
        ])->assertCreated();

    // update quantity
    $cartList = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson('/api/v1/cart')->json('data');
    $cartId = $cartList[0]['id'];

    $this->withHeader('Authorization', 'Bearer ' . $token)
        ->putJson('/api/v1/cart/' . $cartId, [
            'quantity' => 3,
        ])->assertOk();

    // place order
    $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson('/api/v1/orders')
        ->assertCreated();
});


