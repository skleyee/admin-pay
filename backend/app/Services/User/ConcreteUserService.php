<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ConcreteUserService implements UserService
{
    public function register(array $userData)
    {
        try {
            $userData['password'] = Hash::make($userData['password']);
            return User::query()->create($userData);
        } catch (\Exception $e) {
            logger('register error:', [
               $e->getCode(),
               $e->getMessage()
            ]);
            throw new \Exception('Error during creating user, check logs');
        }
    }

    public function login(array $userData)
    {
        $user = User::where('login', $userData['login'])->first();
        if (!Hash::check($userData['password'], $user->password)) {
            throw new \Exception('Password mismatch');
        }
        return $user;
    }
}
