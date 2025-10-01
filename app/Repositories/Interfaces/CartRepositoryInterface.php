<?php

namespace App\Repositories\Interfaces;

use App\Models\Cart;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CartRepositoryInterface
{
    public function paginateByUser(int $userId, int $perPage = 15): LengthAwarePaginator;
    public function updateOrCreate(int $userId, int $productId, int $quantity): Cart;
    public function findForUserOrFail(int $userId, int $cartId): Cart;
    public function updateQuantity(Cart $cart, int $quantity): bool;
    public function delete(Cart $cart): bool;
}


