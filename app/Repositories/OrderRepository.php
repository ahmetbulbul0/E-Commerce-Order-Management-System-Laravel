<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderRepositoryInterface
{
    public function paginate(int $perPage = 15, ?int $userId = null): LengthAwarePaginator
    {
        $query = Order::query();
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        return $query->orderByDesc('id')->paginate($perPage);
    }

    public function findOrFail(int $id): Order
    {
        return Order::findOrFail($id);
    }

    public function create(array $attributes): Order
    {
        return Order::create($attributes);
    }

    public function update(Order $order, array $attributes): bool
    {
        return $order->update($attributes);
    }

    public function delete(Order $order): bool
    {
        return $order->delete();
    }
}
