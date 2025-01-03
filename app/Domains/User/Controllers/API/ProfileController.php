<?php

declare(strict_types=1);

namespace App\Domains\User\Controllers\API;

use App\Domains\User\DataTransferObjects\UserData;
use App\Domains\User\Enums\RoleEnum;
use App\Support\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends ApiController
{
    public function __construct()
    {
        $this->middleware(sprintf('role:%s', RoleEnum::User->value));
    }

    public function show(Request $request): JsonResponse
    {
        return $this->sendJsonResponse(UserData::fromModel($request->user())->include('city'));
    }
}
