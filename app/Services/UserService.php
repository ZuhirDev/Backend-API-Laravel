<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService{

    public function createUserService(array $data)
    {
        return User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => Hash::make($data['password']),
        ]);
    }   

    public function updateUserService(array $data)
    {
        $user = User::find(JWTAuth::user()->id);

        $user->update([
            'name' => $data['name'] ?? $user->name,
        ]);

        return $user;
    }
}