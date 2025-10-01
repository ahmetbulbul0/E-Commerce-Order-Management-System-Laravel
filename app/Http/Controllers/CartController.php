<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $items = Cart::with('product')
            ->where('user_id', $request->user()->id)
            ->paginate($request->integer('per_page', 15));

        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        $item = Cart::updateOrCreate(
            ['user_id' => $request->user()->id, 'product_id' => $product->id],
            ['quantity' => $validated['quantity']]
        );

        return response()->json($item, 201);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $item = Cart::where('user_id', $request->user()->id)->findOrFail($id);
        $item->update(['quantity' => $validated['quantity']]);
        return response()->json($item);
    }

    public function destroy(Request $request, int $id)
    {
        $item = Cart::where('user_id', $request->user()->id)->findOrFail($id);
        $item->delete();
        return response()->json(['message' => 'Removed']);
    }
}


