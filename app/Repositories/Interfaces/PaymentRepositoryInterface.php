<?php

namespace App\Repositories\Interfaces;

use App\Models\Payment;

interface PaymentRepositoryInterface
{
    public function findOrFail(int $id): Payment;
    public function create(array $attributes): Payment;
    public function update(Payment $payment, array $attributes): bool;
    public function delete(Payment $payment): bool;
}
