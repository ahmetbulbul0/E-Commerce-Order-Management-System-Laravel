<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;
    public function findOrFail(int $id): Product;
    public function create(array $attributes): Product;
    public function update(Product $product, array $attributes): bool;
    public function delete(Product $product): bool;
}


