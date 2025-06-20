<?php

declare(strict_types=1);

namespace App\Domains\Notification\Repositories;

use App\Support\Repositories\Repository;

class EmotionRepository extends Repository
{
    /** @var array<string>|null */
    protected ?array $searchableColumns = ['name'];

    /** @var array<string>|null */
    protected ?array $sortableColumns = ['name'];

    protected string $defaultSortDirection = self::SORT_DIRECTION_ASC;

    protected string $model = \App\Domains\Notification\Models\Emotion::class;
}
