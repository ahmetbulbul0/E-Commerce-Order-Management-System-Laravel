<?php

namespace App\Services;

use App\Models\Cart;

class OrderService
{
    public function calculateTotals(int $userId): array
    {
        $items = Cart::with('product')->where('user_id', $userId)->get();
        $subtotal = $items->sum(fn ($i) => $i->quantity * $i->product->price);
        $discount = $this->applyDiscount($subtotal);
        $total = max(0, $subtotal - $discount);
        return compact('subtotal', 'discount', 'total');
    }

    public function applyDiscount(float $subtotal): float
    {
        return $subtotal >= 200 ? round($subtotal * 0.1, 2) : 0.0;
    }
}


