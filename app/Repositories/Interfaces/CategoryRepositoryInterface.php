<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function paginate(int $perPage = 15, ?string $search = null): LengthAwarePaginator;
    public function create(array $attributes): Category;
    public function findOrFail(int $id): Category;
    public function update(Category $category, array $attributes): bool;
    public function delete(Category $category): bool;
}
