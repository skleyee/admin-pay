<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\User;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {

    }
    public function store(PaymentRequest $request, PaymentService $paymentService)
    {
        $user = User::query()->where('login', $request->login)->first();
        $data = $request->merge([
            'user_id' => $user->id
        ])->toArray();
        $payment = $paymentService->createPayment($data);
        return response()->json([
            'success' => true,
            'data'    => [
              'payment' => $payment
            ]
        ]);
    }
}
