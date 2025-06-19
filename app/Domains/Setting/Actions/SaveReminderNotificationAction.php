<?php

declare(strict_types=1);

namespace App\Domains\Setting\Actions;

use App\Domains\Setting\DataTransferObjects\ReminderNotificationData;
use App\Domains\Setting\Models\ReminderNotification;
use App\Support\Actions\Action;

class SaveReminderNotificationAction extends Action
{
    public function __construct(
        protected readonly ReminderNotification $model,
        protected readonly ReminderNotificationData $data
    ) {}

    public function handle()
    {
        $this->model->fill($this->data->only(
            'title',
            'message',
            'is_active',
        )->toArray());

        $this->model->save();

        return $this->model;
    }
}
