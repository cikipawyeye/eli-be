<?php

declare(strict_types=1);

namespace App\Domains\Notification\DataTransferObjects;

use App\Domains\Notification\Models\Emotion;
use Spatie\LaravelData\Data;

class EmotionData extends Data
{
    public function __construct(
        public readonly string|int|null $id,
        public readonly string $name,
    ) {}

    public static function fromModel(Emotion $model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
        );
    }
}
