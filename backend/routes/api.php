<?php

use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\VerifyApiXSign;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'index']);
        });
    Route::middleware(VerifyApiXSign::class)->group(function () {
        Route::post('/payments', [PaymentController::class, 'store']);
        Route::put('/payments', [PaymentController::class, 'update']);
    });

});

Route::post('/sign-up', [AuthController::class, 'register']);
Route::post('/sign-in', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
