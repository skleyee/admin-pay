<?php

namespace App\Services\User;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserService::class, ConcreteUserService::class);
    }
}
