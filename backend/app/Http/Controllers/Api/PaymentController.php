<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\User;
use App\Services\Payment\PaymentService;

class PaymentController extends Controller
{
    public function __construct()
    {

    }
    public function store(CreatePaymentRequest $request, PaymentService $paymentService)
    {
        $user = User::query()->where('login', $request->login)->first();
        $data = $request->merge([
            'user_id' => $user->id
        ])->toArray();
        $payment = $paymentService->createPayment($user, $data);
        return response()->json([
            'success' => true,
            'data'    => [
              'payment' => $payment
            ]
        ]);
    }

    public function update(UpdatePaymentRequest $request, PaymentService $paymentService)
    {
        $payment = $paymentService->updatePaymentStatus($request->id, $request->status);

        return response()->json([
           'success' => true,
           'data'    => [
               'payment' => $payment
           ]
        ]);
    }
}
