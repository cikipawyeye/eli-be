<?php

declare(strict_types=1);

namespace App\Domains\User\Actions;

use App\Domains\User\DataTransferObjects\UserData;
use App\Domains\User\Enums\RoleEnum;
use App\Domains\User\Exceptions\UserException;
use App\Domains\User\Models\User;
use App\Support\Actions\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SaveUserAction extends Action
{
    public function __construct(
        protected readonly User $model,
        protected readonly UserData $data
    ) {}

    public function handle(): User
    {
        if ($this->model->hasAnyRole(RoleEnum::SuperAdmin->value, RoleEnum::Admin->value)) {
            throw UserException::cannotUpdateAdminToUser();
        }

        $this->model->fill($this->data->only(
            'name',
            'email',
            'birth_date',
            'job',
            'job_type',
            'gender',
            'phone_number',
        )->toArray());

        $this->model->email_verified_at = $this->data->email_verified_at;
        $this->model->is_premium = $this->data->is_premium;
        $this->model->city()->associate($this->data->city_code);

        if (!empty($this->data->password)) {
            $this->model->password = Hash::make($this->data->password);
        }

        DB::transaction(function () {
            $this->model->save();
            $this->model->syncRoles(RoleEnum::User->value);
        });

        return $this->model;
    }
}
