<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function paginate(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        $query = Category::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        return $query->paginate($perPage);
    }

    public function create(array $attributes): Category
    {
        return Category::create($attributes);
    }

    public function findOrFail(int $id): Category
    {
        return Category::findOrFail($id);
    }

    public function update(Category $category, array $attributes): bool
    {
        return $category->update($attributes);
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}
