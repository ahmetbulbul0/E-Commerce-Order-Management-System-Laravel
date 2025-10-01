<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, int $orderId)
    {
        $order = Order::findOrFail($orderId);
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'in:success,failed,refunded'],
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $validated['amount'],
            'status' => $validated['status'] ?? 'success',
        ]);

        return response()->json($payment, 201);
    }

    public function show(int $id)
    {
        return response()->json(Payment::findOrFail($id));
    }
}


