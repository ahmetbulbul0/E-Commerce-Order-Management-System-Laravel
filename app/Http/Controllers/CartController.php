<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\StoreCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}
    public function index(Request $request)
    {
        $items = $this->cartService->listForUser($request->user()->id, $request->integer('per_page', 15));
        return $this->success($items);
    }

    public function store(StoreCartRequest $request)
    {
        $item = $this->cartService->addOrUpdate($request->user()->id, $request->validated()['product_id'], $request->validated()['quantity']);
        return $this->created($item);
    }

    public function update(UpdateCartRequest $request, int $id)
    {
        $item = $this->cartService->updateQuantity($request->user()->id, $id, $request->validated()['quantity']);
        return $this->success($item);
    }

    public function destroy(Request $request, int $id)
    {
        $this->cartService->remove($request->user()->id, $id);
        return $this->deleted('Removed');
    }
}


