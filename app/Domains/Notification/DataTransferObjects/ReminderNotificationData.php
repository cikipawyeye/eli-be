<?php

declare(strict_types=1);

namespace App\Domains\Notification\DataTransferObjects;

use App\Domains\Notification\Models\ReminderNotification;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class ReminderNotificationData extends Data
{
    public function __construct(
        public readonly string|int|null $id,
        public readonly string $title,
        public readonly string $message,
        public readonly bool $is_active,
        public readonly Lazy|string|null $image_url,
        public readonly Lazy|string|null $image_url_optimized,
    ) {}

    public static function fromModel(ReminderNotification $model): self
    {
        return new self(
            id: $model->id,
            title: $model->title,
            message: $model->message,
            is_active: $model->is_active,
            image_url: Lazy::create(fn () => $model->getFirstMediaUrl('image')),
            image_url_optimized: Lazy::create(
                fn () => $model->getFirstMediaUrl('image', 'optimized')
            ),
        );
    }
}
