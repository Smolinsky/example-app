<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {
    }

    /**
     * @param LoginRequest $request
     * @return array
     * @throws ValidationException
     */
//    public function login(LoginRequest $request): array
//    {
//        try {
//            return $this->authService->authenticateByCredentials($request->email, $request->password);
//        } catch (AuthenticationException $e) {
//            throw ValidationException::withMessages([
//                'email' => $e->getMessage(),
//            ]);
//        }
//    }

//    public function logout(): JsonResponse
//    {
//        Auth::user()->currentAccessToken()->delete();
//
//        return response()->json([
//            'message' => 'Successfully logged out.',
//        ]);
//    }

//passport
    public function login(LoginRequest $request): array
    {
        try {
            return $this->authService->authenticateByCredentials($request->email, $request->password);
        } catch (AuthenticationException $e) {
            throw ValidationException::withMessages([
                'email' => $e->getMessage(),
            ]);
        }
    }

    public function logout(): JsonResponse
    {
        Auth::user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out',
        ], Response::HTTP_OK);
    }

    public function oauth(Request $request)
    {
        $data = [
            'grant_type' => $request->input('grant_type'),
            'client_id' => $request->input('client_id'),
            'client_secret' => $request->input('client_secret'),
            'provider' => $request->input('provider'),
            'access_token' => $request->input('access_token')
        ];

        $url = route('passport.token');

        $request->request->add($data);

        $tokenRequest = $request->create(
            $url,
            'post',
        );

        return Route::dispatch($tokenRequest);
    }

}
