<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query();
        $limit = $request->get('limit', 5);
        return response()->json([
            'success' => true,
            'data'    => $users->paginate($limit)
        ], 200);
    }
}
