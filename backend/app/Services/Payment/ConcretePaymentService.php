<?php

namespace App\Services\Payment;

use App\Models\Payment;

class ConcretePaymentService implements PaymentService
{

    public function createPayment(array $paymentData): Payment
    {
        return Payment::query()->create([
            'user_id' => $paymentData['user_id'],
            'payload' => $paymentData['details'],
            'amount'  => $paymentData['amount'],
            'currency_iso_code' => $paymentData['currency'],
            'status'            => $paymentData['status']
        ]);
    }
}
