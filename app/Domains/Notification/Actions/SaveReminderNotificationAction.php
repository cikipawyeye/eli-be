<?php

declare(strict_types=1);

namespace App\Domains\Notification\Actions;

use App\Domains\Notification\DataTransferObjects\ReminderNotificationData;
use App\Domains\Notification\Models\ReminderNotification;
use App\Support\Actions\Action;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class SaveReminderNotificationAction extends Action
{
    public function __construct(
        protected readonly ReminderNotification $model,
        protected readonly ReminderNotificationData $data,
        protected readonly ?UploadedFile $image = null,
    ) {}

    public function handle()
    {
        $this->model->fill($this->data->only(
            'title',
            'message',
            'is_active',
            'notification_time',
        )->toArray());

        DB::transaction(function () {
            $this->model->save();

            if ($this->image instanceof UploadedFile) {
                $this->model->addMedia($this->image)
                    ->toMediaCollection('image', 'public');
            } elseif (! $this->image) {
                $this->model->clearMediaCollection('image');
            }
        });

        return $this->model;
    }
}
