<?php

namespace App\Http\Controllers\Api\Registration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Registration\RegistrationRequest;
use App\Services\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RegistrationController extends Controller
{
    protected $authService;
    public function __construct(
        AuthService $authService
    ) {
        $this->authService = $authService;
    }

    // sanctum registration
//    public function register(RegistrationRequest $request): JsonResponse
//    {
//        $user = $this->authService->register($request->validated());
//
//        $role = Role::create(['name' => 'admin']);
//        $permission = Permission::create(['name' => 'edit']);
//
//        $role->givePermissionTo($permission);
//        $permission->assignRole($role);
//
//        return response()->json([
//            'message' => 'User registered successfully.',
//            'user' => $user,
//        ], 201);
//    }

    //passport registration
    public function register(RegistrationRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());

        // sends a verification email once registration is done
        event(new Registered($user));

        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json([
//            'message' => 'User registered successfully.',
//            'user' => $user,
            'access_token' => $accessToken
        ], Response::HTTP_OK);
    }

}
