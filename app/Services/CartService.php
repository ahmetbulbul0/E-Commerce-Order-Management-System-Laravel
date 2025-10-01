<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function getActiveCart(int $userId): ?Cart
    {
        return Cart::with(['items.product'])
            ->where('user_id', $userId)
            ->active()
            ->first();
    }

    public function addItem(int $userId, array $data): Cart
    {
        return DB::transaction(function () use ($userId, $data) {
            $cart = $this->getOrCreateActiveCart($userId);
            
            $existingItem = $cart->items()->where('product_id', $data['product_id'])->first();
            
            if ($existingItem) {
                $existingItem->update([
                    'quantity' => $existingItem->quantity + $data['quantity']
                ]);
            } else {
                $cart->items()->create([
                    'product_id' => $data['product_id'],
                    'quantity' => $data['quantity']
                ]);
            }

            return $cart->fresh(['items.product']);
        });
    }

    public function updateItem(int $userId, int $productId, int $quantity): Cart
    {
        return DB::transaction(function () use ($userId, $productId, $quantity) {
            $cart = $this->getActiveCart($userId);
            
            if (!$cart) {
                throw new \Exception('Cart not found');
            }

            $item = $cart->items()->where('product_id', $productId)->first();
            
            if (!$item) {
                throw new \Exception('Item not found in cart');
            }

            $item->update(['quantity' => $quantity]);

            return $cart->fresh(['items.product']);
        });
    }

    public function removeItem(int $userId, int $productId): Cart
    {
        return DB::transaction(function () use ($userId, $productId) {
            $cart = $this->getActiveCart($userId);
            
            if (!$cart) {
                throw new \Exception('Cart not found');
            }

            $cart->items()->where('product_id', $productId)->delete();

            return $cart->fresh(['items.product']);
        });
    }

    public function clearCart(int $userId): void
    {
        DB::transaction(function () use ($userId) {
            $cart = $this->getActiveCart($userId);
            
            if ($cart) {
                $cart->items()->delete();
            }
        });
    }

    public function archiveCart(int $userId): void
    {
        DB::transaction(function () use ($userId) {
            $cart = $this->getActiveCart($userId);
            
            if ($cart) {
                $cart->update(['status' => 'archived']);
            }
        });
    }

    private function getOrCreateActiveCart(int $userId): Cart
    {
        $cart = $this->getActiveCart($userId);
        
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $userId,
                'status' => 'active'
            ]);
        }

        return $cart;
    }
}