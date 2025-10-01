<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CartRepository implements CartRepositoryInterface
{
    public function paginateByUser(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return Cart::with('product')
            ->where('user_id', $userId)
            ->paginate($perPage);
    }

    public function updateOrCreate(int $userId, int $productId, int $quantity): Cart
    {
        return Cart::updateOrCreate(
            ['user_id' => $userId, 'product_id' => $productId],
            ['quantity' => $quantity]
        );
    }

    public function findForUserOrFail(int $userId, int $cartId): Cart
    {
        return Cart::where('user_id', $userId)->findOrFail($cartId);
    }

    public function updateQuantity(Cart $cart, int $quantity): bool
    {
        return $cart->update(['quantity' => $quantity]);
    }

    public function delete(Cart $cart): bool
    {
        return $cart->delete();
    }
}


