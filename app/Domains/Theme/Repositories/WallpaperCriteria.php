<?php

declare(strict_types=1);

namespace App\Domains\Theme\Repositories;

use App\Support\Repositories\Criteria;

class WallpaperCriteria extends Criteria
{
    public function __construct(
        public readonly ?int $limit,
        public readonly ?string $search,
    ) {}
}
