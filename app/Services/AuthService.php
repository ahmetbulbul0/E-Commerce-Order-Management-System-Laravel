<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $attributes): array
    {
        $user = User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => Hash::make($attributes['password']),
            'role' => 'customer',
        ]);

        $token = $user->createToken('auth')->plainTextToken;

        return [$user, $token];
    }

    public function login(array $credentials): ?array
    {
        /** @var User|null $user */
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        $token = $user->createToken('auth')->plainTextToken;
        
        return [$user, $token];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }
}


