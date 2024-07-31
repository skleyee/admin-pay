<?php

use App\Http\Controllers\Api\PaymentController;
use App\Http\Middleware\VerifyApiXSign;
use Illuminate\Support\Facades\Route;


Route::middleware(VerifyApiXSign::class)->group(function () {
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::put('/payments', [PaymentController::class, 'update']);
});
