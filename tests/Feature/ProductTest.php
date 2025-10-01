<?php

use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lists products', function () {
    Category::factory()->hasProducts(3)->create();

    $response = $this->getJson('/api/v1/products');
    $response->assertOk()->assertJsonStructure(['data']);
});

it('admin creates a product', function () {
    $admin = User::factory()->create(['role' => 'admin', 'password' => 'password']);
    $token = $admin->createToken('t')->plainTextToken;

    $category = Category::factory()->create();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson('/api/v1/products', [
            'name' => 'Phone',
            'price' => 100,
            'stock' => 10,
            'category_id' => $category->id,
        ]);

    $response->assertCreated()->assertJsonPath('name', 'Phone');
});


