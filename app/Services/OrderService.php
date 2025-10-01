<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository
    ) {}

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

    public function createFromCart(int $userId, array $totals): Order
    {
        return DB::transaction(function () use ($userId, $totals) {
            $order = $this->orderRepository->create([
                'user_id' => $userId,
                'total_amount' => $totals['total'],
                'status' => 'pending',
            ]);

            Cart::where('user_id', $userId)->delete();
            return $order;
        });
    }

    public function getPaginated(int $perPage = 15, ?int $userId = null): LengthAwarePaginator
    {
        return $this->orderRepository->paginate($perPage, $userId);
    }

    public function findOrFail(int $id): Order
    {
        return $this->orderRepository->findOrFail($id);
    }

    public function updateStatus(int $id, string $status): Order
    {
        $order = $this->orderRepository->findOrFail($id);
        $this->orderRepository->update($order, ['status' => $status]);
        return $order->fresh();
    }
}


