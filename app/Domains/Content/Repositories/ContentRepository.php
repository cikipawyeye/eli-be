<?php

declare(strict_types=1);

namespace App\Domains\Content\Repositories;

use App\Support\Repositories\Repository;

class ContentRepository extends Repository
{
    protected string $model = \App\Domains\Content\Models\Content::class;

    /** @var array<string>|null */
    protected ?array $searchableColumns = ['title'];

    /** @var array<string>|null */
    protected ?array $with = ['media'];

    protected string $defaultSortDirection = self::SORT_DIRECTION_ASC;

    protected function subcategory(?int $subcategory): static
    {
        if ($subcategory) {
            $this->query->where('subcategory_id', $subcategory);
        }

        return $this;
    }
}
