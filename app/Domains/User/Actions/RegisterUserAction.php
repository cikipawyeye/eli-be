<?php

declare(strict_types=1);

namespace App\Domains\User\Actions;

use App\Domains\User\DataTransferObjects\UserData;
use App\Domains\User\Enums\RoleEnum;
use App\Domains\User\Models\User;
use App\Support\Actions\Action;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction extends Action
{
    public function __construct(
        protected readonly UserData $data
    ) {}

    public function handle(): User
    {
        $user = new User();
        $user->fill($this->data->toArray());
        $user->password = Hash::make($this->data->password);
        $user->city()->associate($this->data->city_code);
        
        DB::transaction(function () use ($user) {
            $user->save();
            $user->assignRole(RoleEnum::User->value);
            $user->sendEmailVerificationNotification();
        });

        event(new Registered($user));

        Auth::login($user);

        return $user;
    }
}
