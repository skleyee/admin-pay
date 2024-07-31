<?php

namespace App\Services\Payment;

use App\Models\Payment;
use App\Models\User;

interface PaymentService
{
    public function createPayment(User $user, array $paymentData): Payment;

    public function updatePaymentStatus(int $paymentId, string $paymentStatus): Payment;
}
