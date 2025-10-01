<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\UpdateOrderStatusRequest;
use App\Models\Cart;
use App\Services\OrderService;
use App\Notifications\OrderPlaced;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function store(Request $request)
    {
        $user = $request->user();
        $cart = Cart::with('items.product')->where('user_id', $user->id)->active()->first();
        
        if (!$cart || $cart->items->isEmpty()) {
            return $this->fail('Cart is empty', 422);
        }

        $totals = $this->orderService->calculateTotals($user->id);
        $order = $this->orderService->createFromCart($user->id, $totals);

        // Notify asynchronously
        $user->notify(new OrderPlaced($order));

        return $this->created($order);
    }

    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 15);

        $orders = $this->orderService->getPaginated($perPage, $request->user()->id);

        return $this->success($orders);
    }

    public function updateStatus(UpdateOrderStatusRequest $request, int $id)
    {
        $order = $this->orderService->updateStatus($id, $request->validated()['status']);

        return $this->success($order);
    }
}
