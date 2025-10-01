<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Repositories\Interfaces\PaymentRepositoryInterface;

class PaymentService
{
    public function __construct(private PaymentRepositoryInterface $paymentRepository) {}

    public function createForOrder(int $orderId, array $attributes): Payment
    {
        Order::findOrFail($orderId);
        
        return $this->paymentRepository->create([
            'order_id' => $orderId,
            'amount' => $attributes['amount'],
            'status' => $attributes['status'] ?? 'success',
        ]);
    }

    public function findOrFail(int $id): Payment
    {
        return $this->paymentRepository->findOrFail($id);
    }

    public function update(int $id, array $attributes): Payment
    {
        $payment = $this->paymentRepository->findOrFail($id);
        $this->paymentRepository->update($payment, $attributes);
        return $payment->fresh();
    }

    public function delete(int $id): bool
    {
        $payment = $this->paymentRepository->findOrFail($id);
        return $this->paymentRepository->delete($payment);
    }
}
