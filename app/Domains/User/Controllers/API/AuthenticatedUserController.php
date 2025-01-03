<?php

namespace App\Domains\User\Controllers\API;

use App\Domains\User\Requests\API\LoginRequest;
use App\Support\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedUserController extends ApiController
{
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
}
