<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository
    ) {}

    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        return $this->categoryRepository->paginate($perPage, $search);
    }

    public function create(array $attributes): Category
    {
        return $this->categoryRepository->create($attributes);
    }

    public function findOrFail(int $id): Category
    {
        return $this->categoryRepository->findOrFail($id);
    }

    public function update(int $id, array $attributes): Category
    {
        $category = $this->categoryRepository->findOrFail($id);
        $this->categoryRepository->update($category, $attributes);
        return $category->fresh();
    }

    public function delete(int $id): bool
    {
        $category = $this->categoryRepository->findOrFail($id);
        return $this->categoryRepository->delete($category);
    }
}
