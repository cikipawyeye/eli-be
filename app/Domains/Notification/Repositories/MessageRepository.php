<?php

declare(strict_types=1);

namespace App\Domains\Notification\Repositories;

use App\Support\Repositories\Repository;

class MessageRepository extends Repository
{
    /** @var array<string>|null */
    protected ?array $searchableColumns = ['content'];

    /** @var array<string>|null */
    protected ?array $sortableColumns = ['content'];

    protected string $defaultSortDirection = self::SORT_DIRECTION_ASC;

    protected string $model = \App\Domains\Notification\Models\Message::class;

    public function emotion(?int $emotionId): self
    {
        $this->query->where('emotion_id', $emotionId);

        return $this;
    }
}
