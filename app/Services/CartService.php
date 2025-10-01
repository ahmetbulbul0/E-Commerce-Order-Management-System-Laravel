<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CartService
{
    public function __construct(private CartRepositoryInterface $cartRepository) {}

    public function listForUser(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->cartRepository->paginateByUser($userId, $perPage);
    }

    public function addOrUpdate(int $userId, int $productId, int $quantity): Cart
    {
        Product::findOrFail($productId);
        return $this->cartRepository->updateOrCreate($userId, $productId, $quantity);
    }

    public function updateQuantity(int $userId, int $cartId, int $quantity): Cart
    {
        $item = $this->cartRepository->findForUserOrFail($userId, $cartId);
        $this->cartRepository->updateQuantity($item, $quantity);
        return $item->fresh();
    }

    public function remove(int $userId, int $cartId): bool
    {
        $item = $this->cartRepository->findForUserOrFail($userId, $cartId);
        return $this->cartRepository->delete($item);
    }
}


