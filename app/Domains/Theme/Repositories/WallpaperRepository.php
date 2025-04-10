<?php

declare(strict_types=1);

namespace App\Domains\Theme\Repositories;

use App\Support\Repositories\Repository;

class WallpaperRepository extends Repository
{
    /** @var array<string>|null */
    protected ?array $searchableColumns = ['name'];

    protected string $defaultSort = 'name';

    protected string $defaultSortDirection = self::SORT_DIRECTION_ASC;

    /** @var array<string>|null */
    protected ?array $with = ['media'];

    protected string $model = \App\Domains\Theme\Models\Wallpaper::class;
}
