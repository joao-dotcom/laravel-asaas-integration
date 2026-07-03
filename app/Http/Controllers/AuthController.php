<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $emailCheck = $this->authService->checkEmail($request);

        if (!$emailCheck) {
            return response()->json([
                'error' => 'Email not found.'
            ], 401);
        }

        $passowordCheck = $this->authService->checkPassword($request);

        if (!$passowordCheck) {
            return response()->json([
                'error' => 'Incorrect password.'
            ], 401);
        }

        $token = auth('api')->attempt($credentials);

        if (!$token) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        $user = $this->authService->getUser($request);

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function register(StoreUserRequest $request)
    {
        $data = $request->validated();

        $data['passowrd'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json($user, 201);
    }
}