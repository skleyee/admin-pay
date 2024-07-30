<?php

namespace App\Services\Payment;

use App\Models\Payment;

interface PaymentService
{
    public function createPayment(array $paymentData): Payment;
}
