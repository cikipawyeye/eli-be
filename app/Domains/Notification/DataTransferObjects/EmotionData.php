<?php

declare(strict_types=1);

namespace App\Domains\Notification\DataTransferObjects;

use App\Domains\Notification\Models\Emotion;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class EmotionData extends Data
{
    public function __construct(
        public readonly string|int|null $id,
        public readonly string $name,
        public readonly Lazy|int|null $messages_count,
    ) {}

    public static function fromModel(Emotion $model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
            messages_count: Lazy::create(fn() => $model->messages()->count())
        );
    }
}
