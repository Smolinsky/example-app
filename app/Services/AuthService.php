<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthService
{
    public function authenticateByCredentials(string $email, string $password): array
    {
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            throw new AuthenticationException('Provided credentials are incorrect.');
        }

        $user = auth()->user();
        $tokenObject = $user->createToken('authToken');
        $token = $tokenObject->accessToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function register($request)
    {
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);
    }

}
