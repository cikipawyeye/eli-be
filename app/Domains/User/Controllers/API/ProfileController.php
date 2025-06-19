<?php

declare(strict_types=1);

namespace App\Domains\User\Controllers\API;

use App\Domains\User\Actions\UpdateLastActiveAction;
use App\Domains\User\Actions\UpdateUserProfileAction;
use App\Domains\User\DataTransferObjects\UserData;
use App\Domains\User\Enums\RoleEnum;
use App\Domains\User\Requests\API\UpdateProfileRequest;
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
        // Update last active timestamp
        UpdateLastActiveAction::dispatchAfterResponse(
            $request->user()
        );

        return $this->sendJsonResponse(UserData::fromModel($request->user())->include('city'));
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = dispatch_sync(new UpdateUserProfileAction(
            $request->user(),
            UserData::from($request->validated()),
        ));

        return $this->sendJsonResponse(
            data: UserData::fromModel($user)->include('city'),
            message: __('app.updated_data', ['data' => __('app.profile')])
        );
    }
}
