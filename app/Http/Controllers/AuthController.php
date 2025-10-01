<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, AuthService $authService)
    {
        $validated = $request->validated();

        [$user, $token] = $authService->register($validated);

        return $this->created(['token' => $token, 'user' => $user]);
    }

    public function login(LoginRequest $request, AuthService $authService)
    {
        $validated = $request->validated();

        $result = $authService->login($validated);

        if (!$result) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        [$user, $token] = $result;

        return $this->success(['token' => $token, 'user' => $user]);
    }

    public function logout(Request $request, AuthService $authService)
    {
        $authService->logout($request->user());
        
        return $this->success(['message' => 'Logged out']);
    }

    public function me(Request $request)
    {
        return $this->success(auth()->user());
    }
}
