<?php

use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('/payments', [PaymentController::class, 'store']);
Route::put('/payments', [PaymentController::class, 'update']);
