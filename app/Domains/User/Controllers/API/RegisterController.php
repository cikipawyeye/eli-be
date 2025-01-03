<?php

namespace App\Domains\User\Controllers\API;

use App\Domains\User\Actions\RegisterUserAction;
use App\Domains\User\DataTransferObjects\UserData;
use App\Domains\User\Requests\API\RegisterRequest;
use App\Support\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;

class RegisterController extends ApiController
{
    public function cities(Request $request): JsonResponse
    {
        $query = City::select('name', 'code');

        if ($request->filled('search')) {
            $query->where('name', 'ilike', sprintf('%%%s%%', $request->get('search')));
        }

        return $this->sendJsonResponse(
            data: $query->get(),
        );
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = dispatch_sync(new RegisterUserAction(
            UserData::from($request->validated())
        ));

        return $this->sendJsonResponse(
            data: [
                'user' => UserData::fromModel($user)->include('city'),
                'token' => $user->createToken('api')->plainTextToken,
            ],
            message: 'User registered successfully'
        );
    }
}
