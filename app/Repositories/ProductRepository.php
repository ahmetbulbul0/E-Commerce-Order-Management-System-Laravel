<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = Product::query()->with('category');

        if (!empty($filters['category_id'])) {
            $query->where('category_id', (int) $filters['category_id']);
        }
        
        if (array_key_exists('search', $filters)) {
            $query->searchByName((string) $filters['search']);
        }

        if (array_key_exists('min_price', $filters) || array_key_exists('max_price', $filters)) {
            $query->filterByPrice($filters['min_price'] ?? null, $filters['max_price'] ?? null);
        }

        return $query->paginate($perPage);
    }

    public function findOrFail(int $id): Product
    {
        return Product::with('category')->findOrFail($id);
    }

    public function create(array $attributes): Product
    {
        return Product::create($attributes);
    }

    public function update(Product $product, array $attributes): bool
    {
        return $product->update($attributes);
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }
}


