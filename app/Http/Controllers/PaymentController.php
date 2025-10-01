<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\StorePaymentRequest;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService) {}

    public function store(StorePaymentRequest $request, int $orderId)
    {
        $payment = $this->paymentService->createForOrder($orderId, $request->validated());
        return $this->created($payment);
    }

    public function show(int $id)
    {
        $payment = $this->paymentService->findOrFail($id);
        return $this->success($payment);
    }
}