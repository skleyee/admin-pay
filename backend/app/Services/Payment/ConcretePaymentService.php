<?php

namespace App\Services\Payment;

use App\Models\Payment;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class ConcretePaymentService implements PaymentService
{

    public function createPayment(User $user, array $paymentData): Payment
    {
        try {
            return DB::transaction(function () use ($user, $paymentData) {
                $payment = Payment::query()->create([
                    'user_id' => $paymentData['user_id'],
                    'payload' => $paymentData['details'],
                    'amount' => $paymentData['amount'],
                    'currency_iso_code' => $paymentData['currency'],
                    'status' => $paymentData['status']
                ]);

                $user->topUpBalance($payment->amount);

                return $payment;
            });
        } catch (Exception $e) {
            logger("createPayment error", [
                'payment_data' => $paymentData,
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updatePaymentStatus(int $paymentId, string $paymentStatus): Payment
    {
        $payment = Payment::query()->find($paymentId);
        if (!$payment) {
            logger("There is no payment with $paymentId id");
            throw new Exception("There is no payment with $paymentId id");
        }
        try {
            $payment->update([
               'status' => $paymentStatus
            ]);
            return $payment;
        } catch (Exception $e) {
            logger("updatePaymentStatus error for id $paymentId", [
               'code' => $e->getCode(),
               'message' => $e->getMessage()
            ]);
        }
    }
}
