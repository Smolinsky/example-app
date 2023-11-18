<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends Controller
{
    public function forgot(ForgotPasswordRequest $request): JsonResponse
    {
        $status = Password::sendResetLink(
            $request->validated()
        );

        $statusCode = $status === Password::RESET_LINK_SENT
            ? Response::HTTP_OK
            : Response::HTTP_BAD_REQUEST;

        return response()->json([
            'message' => __($status),
        ], $statusCode);
    }

    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $status = Password::reset(
            $request->validated(),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->save();
            }
        );

        $statusCode = $status === Password::RESET_LINK_SENT
            ? Response::HTTP_OK
            : Response::HTTP_BAD_REQUEST;

        return response()->json([
            'message' => __($status),
        ], $statusCode);
    }
}
