<?php

declare(strict_types=1);

namespace App\Domains\User\Controllers\API;

use App\Domains\User\Enums\RoleEnum;
use App\Domains\User\Requests\API\ChangePasswordRequest;
use App\Domains\User\Requests\API\LoginRequest;
use App\Support\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedUserController extends ApiController
{
    public function __construct()
    {
        $this->middleware(sprintf('role:%s', RoleEnum::User->value))->only('changePassword');
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        return $this->sendJsonResponse(
            data: [
                'token' => $request->user()->createToken('api')->plainTextToken,
            ],
            message: 'User logged in successfully'
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        Auth::guard('web')->logout();

        return $this->sendJsonResponse(message: 'User logged out successfully');
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = $request->user();
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return $this->sendJsonResponse(message: 'Password changed successfully');
    }
}
