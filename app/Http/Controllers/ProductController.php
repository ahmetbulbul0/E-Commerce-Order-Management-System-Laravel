<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with('category');

        if ($categoryId = $request->integer('category_id')) {
            $query->where('category_id', $categoryId);
        }
        $query->searchByName($request->string('search')->toString());
        $query->filterByPrice($request->float('min_price'), $request->float('max_price'));

        $perPage = $request->integer('per_page', 15);
        $cacheKey = sprintf(
            'products:index:c%s:s%s:min%s:max%s:p%s',
            $request->integer('category_id'),
            $request->string('search')->toString(),
            $request->input('min_price'),
            $request->input('max_price'),
            $perPage
        );

        $result = cache()->remember($cacheKey, now()->addMinutes(10), function () use ($query, $perPage) {
            return $query->paginate($perPage);
        });

        return response()->json($result);
    }

    public function show(int $id)
    {
        return response()->json(Product::with('category')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['nullable', 'string'],
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    public function update(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'category_id' => ['sometimes', 'exists:categories,id'],
            'status' => ['nullable', 'string'],
        ]);

        $product->update($validated);
        return response()->json($product);
    }

    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Deleted']);
    }
}


