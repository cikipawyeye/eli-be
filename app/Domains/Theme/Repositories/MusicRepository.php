<?php

declare(strict_types=1);

namespace App\Domains\Theme\Repositories;

use App\Support\Repositories\Repository;

class MusicRepository extends Repository
{
    /** @var array<string>|null */
    protected ?array $searchableColumns = ['title'];

    protected string $defaultSort = 'title';

    protected string $defaultSortDirection = self::SORT_DIRECTION_ASC;

    /** @var array<string>|null */
    protected ?array $with = ['media'];

    protected string $model = \App\Domains\Theme\Models\Music::class;
}
