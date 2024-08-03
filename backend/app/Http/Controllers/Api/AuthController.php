<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserService $concreteUserService
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->concreteUserService->register($request->toArray());
        } catch (Exception $e) {
            logger($e);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = $this->concreteUserService->login($request->toArray());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'token'   => $user->createToken('auth_token')->plainTextToken
        ], 200);
    }

    public function logout(): JsonResponse
    {
        auth('sanctum')->user()->tokens()->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
