<?php

namespace App\Services\V1\Admin\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{


    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw new \LogicException(__('auth.invalid_credentials'));
        }
        $token = $user->createToken('token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout()
    {
        $user = auth()->user();
        $user->currentAccessToken()->delete();
    }
}
