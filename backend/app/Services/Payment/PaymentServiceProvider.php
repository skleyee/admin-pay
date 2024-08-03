<?php

namespace App\Services\Payment;

use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(PaymentService::class, ConcretePaymentService::class);
    }
}
