<?php

declare(strict_types=1);

namespace App\Domains\Content\Repositories;

use App\Support\Repositories\Criteria;

class SubcategoryCriteria extends Criteria
{
    public function __construct(
        public readonly ?int $limit,
        public readonly ?string $search,
        public readonly ?int $category,
        public readonly ?string $type,
        public readonly ?string $active,
        public readonly ?string $access,
        public readonly ?bool $has_content_only,
    ) {}
}
