<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function checkEmail($request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return false;
        }

        return true;
    }

    public function checkPassword($request)
    {
        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password)) {
            return false;
        }

        return true;
    }

    public function getUser($request)
    {
        $user = User::where('email', $request->email)->first();

        return $user;
    }
}