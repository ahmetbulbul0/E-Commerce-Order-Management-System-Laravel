<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function paginate(int $perPage = 15, ?int $userId = null): LengthAwarePaginator;
    public function findOrFail(int $id): Order;
    public function create(array $attributes): Order;
    public function update(Order $order, array $attributes): bool;
    public function delete(Order $order): bool;
}
