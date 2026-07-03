<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Exception;
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
        try {
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
        } catch (Exception $e) {
            return "Erro:" . $e->getMessage();
        }
    }

    public function register(StoreUserRequest $request)
    {
        try {

            $user = $this->authService->register($request);

            return response()->json($user, 201);
        } catch (Exception $e) {
            return "Erro:" . $e->getMessage();
        }
    }
}
