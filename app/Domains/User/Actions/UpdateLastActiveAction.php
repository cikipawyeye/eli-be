<?php

declare(strict_types=1);

namespace App\Domains\User\Actions;

use App\Domains\User\Models\User;
use App\Support\Actions\AsyncAction;

class UpdateLastActiveAction extends AsyncAction
{
    public function __construct(
        private readonly User $model,
    ) {}

    public function handle(): User
    {
        $this->model->last_active_at = now();
        $this->model->save();

        return $this->model;
    }
}
