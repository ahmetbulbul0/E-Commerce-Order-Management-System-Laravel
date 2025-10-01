<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    public function __construct(private ProductRepositoryInterface $productRepository) {}

    public function getPaginated(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->productRepository->paginate($perPage, $filters);
    }

    public function findOrFail(int $id): Product
    {
        return $this->productRepository->findOrFail($id);
    }

    public function create(array $attributes): Product
    {
        return $this->productRepository->create($attributes);
    }

    public function update(int $id, array $attributes): Product
    {
        $product = $this->productRepository->findOrFail($id);
        $this->productRepository->update($product, $attributes);
        return $product->fresh();
    }

    public function delete(int $id): bool
    {
        $product = $this->productRepository->findOrFail($id);
        return $this->productRepository->delete($product);
    }
}
