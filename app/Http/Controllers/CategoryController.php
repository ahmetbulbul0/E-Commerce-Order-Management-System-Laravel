<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService
    ) {}

    public function index(Request $request)
    {
        $search = $request->string('search')->toString() ?: null;
        $perPage = $request->integer('per_page', 15);

        $categories = $this->categoryService->getPaginated($perPage, $search);
        return $this->paginated($categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->create($request->validated());
        return $this->created($category);
    }

    public function update(UpdateCategoryRequest $request, int $id)
    {
        $category = $this->categoryService->update($id, $request->validated());
        return $this->success($category);
    }

    public function destroy(int $id)
    {
        $this->categoryService->delete($id);
        return $this->deleted();
    }
}
