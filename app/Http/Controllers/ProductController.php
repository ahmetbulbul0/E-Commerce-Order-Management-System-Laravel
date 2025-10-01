<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}
    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 15);
        $filters = [
            'category_id' => $request->integer('category_id'),
            'search' => $request->string('search')->toString(),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
        ];

        $cacheKey = sprintf(
            'products:index:c%s:s%s:min%s:max%s:p%s',
            $filters['category_id'],
            $filters['search'],
            $filters['min_price'],
            $filters['max_price'],
            $perPage
        );

        $result = cache()->remember($cacheKey, now()->addMinutes(10), function () use ($perPage, $filters) {
            return $this->productService->getPaginated($perPage, $filters);
        });

        return $this->success($result);
    }

    public function show(int $id)
    {
        return $this->success($this->productService->findOrFail($id));
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->create($request->validated());
        return $this->created($product);
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        $product = $this->productService->update($id, $request->validated());
        return $this->success($product);
    }

    public function destroy(int $id)
    {
        $this->productService->delete($id);
        return $this->deleted();
    }
}
