<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStockAvailable
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $items = Cart::with('product')->where('user_id', $user->id)->get();

        foreach ($items as $item) {
            if ($item->product->stock < $item->quantity) {
                return response()->json([
                    'message' => 'Insufficient stock for product: ' . $item->product->name,
                ], 422);
            }
        }

        return $next($request);
    }
}


