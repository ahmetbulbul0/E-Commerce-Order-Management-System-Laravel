<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('registers a user', function () {
    $response = $this->postJson('/api/v1/auth/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
    ]);

    $response->assertCreated()->assertJsonStructure(['token', 'user' => ['id', 'email']]);
});

it('logs in a user', function () {
    $user = User::factory()->create([
        'password' => 'password',
    ]);

    $response = $this->postJson('/api/v1/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertOk()->assertJsonStructure(['token', 'user' => ['id', 'email']]);
});


