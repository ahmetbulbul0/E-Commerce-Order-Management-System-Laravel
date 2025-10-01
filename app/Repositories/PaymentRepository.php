<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\Interfaces\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function findOrFail(int $id): Payment
    {
        return Payment::findOrFail($id);
    }

    public function create(array $attributes): Payment
    {
        return Payment::create($attributes);
    }

    public function update(Payment $payment, array $attributes): bool
    {
        return $payment->update($attributes);
    }

    public function delete(Payment $payment): bool
    {
        return $payment->delete();
    }
}
