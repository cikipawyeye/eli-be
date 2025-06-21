<?php

declare(strict_types=1);

namespace App\Domains\Notification\DataTransferObjects;

use App\Domains\Notification\Models\Message;
use Spatie\LaravelData\Data;

class MessageData extends Data
{
    public function __construct(
        public readonly string|int|null $id,
        public readonly ?int $emotion_id,
        public readonly string $content,
    ) {}

    public static function fromModel(Message $model): self
    {
        return new self(
            id: $model->id,
            emotion_id: $model->emotion_id,
            content: $model->content,
        );
    }
}
