<?php

namespace App\Services;

use App\Models\Clients;
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

    public function register($request){
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $user_id = $user->id;
        $data['user_id'] = $user_id;

        Clients::create($data);
        
        return $user;
    }
}