<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddItemRequest;
use App\Http\Requests\Cart\UpdateItemRequest;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function index(Request $request)
    {
        $cart = $this->cartService->getActiveCart($request->user()->id);
        return $this->success($cart);
    }

    public function addItem(AddItemRequest $request)
    {
        $cart = $this->cartService->addItem($request->user()->id, $request->validated());
        return $this->success($cart);
    }

    public function updateItem(UpdateItemRequest $request, int $productId)
    {
        $cart = $this->cartService->updateItem($request->user()->id, $productId, $request->validated()['quantity']);
        return $this->success($cart);
    }

    public function removeItem(Request $request, int $productId)
    {
        $cart = $this->cartService->removeItem($request->user()->id, $productId);
        return $this->success($cart);
    }

    public function clear(Request $request)
    {
        $this->cartService->clearCart($request->user()->id);
        return $this->success(['message' => 'Cart cleared']);
    }
}