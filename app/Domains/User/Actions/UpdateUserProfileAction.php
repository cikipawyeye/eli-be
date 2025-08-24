<?php

declare(strict_types=1);

namespace App\Domains\User\Actions;

use App\Domains\User\DataTransferObjects\UserData;
use App\Domains\User\Models\User;
use App\Support\Actions\Action;

class UpdateUserProfileAction extends Action
{
    public function __construct(
        private readonly User $model,
        private readonly UserData $data,
    ) {}

    public function handle(): User
    {
        $this->model->fill(
            $this->data->only(
                'name',
                'email',
                'phone_number',
                'birth_date',
                'city_code',
                'job_type',
                'job',
                'gender',
            )->toArray()
        );
        $this->model->city()->associate($this->data->city_code);

        if ($this->model->isDirty('email')) {
            $this->model->sendEmailVerificationNotification();
            $this->model->email_verified_at = null;
        }

        $this->model->save();

        return $this->model;
    }
}
