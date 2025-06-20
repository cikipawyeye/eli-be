<?php

declare(strict_types=1);

namespace App\Domains\Notification\DataTransferObjects;

use App\Domains\Notification\Models\ReminderNotification;
use Spatie\LaravelData\Data;

class ReminderNotificationData extends Data
{
    public function __construct(
        public readonly string|int|null $id,
        public readonly string $title,
        public readonly string $message,
        public readonly bool $is_active,
    ) {}

    public static function fromModel(ReminderNotification $model): self
    {
        return new self(
            id: $model->id,
            title: $model->title,
            message: $model->message,
            is_active: $model->is_active,
        );
    }
}
