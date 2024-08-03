<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Payment;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->get('limit', 5);
        $filters = $request->query();
        $payments = Payment::query()->with('user')->search(data: $filters);
        if ($filters && $login = $filters['login']) {
            $payments->whereHas('user', function ($query) use ($login) {
                $query->where('login', 'LIKE', '%' . $login . '%');
            });
        }

        return response()->json([
            'success' => true,
            'data'    => $payments->paginate($limit)
        ], 200);
    }

    public function store(CreatePaymentRequest $request, PaymentService $paymentService)
    {
        $user = auth('sanctum')->user();
        $data = $request->merge([
            'user_id' => $user->id,
            'login'   => $user->login,
            'status'  => 'created'
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
