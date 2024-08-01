<?php

namespace App\Services\User;

interface UserService
{
    public function register(array $userData);
    public function login(array $userData);
}
