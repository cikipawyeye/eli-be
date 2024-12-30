<?php

declare(strict_types=1);

namespace App\Domains\Content\Repositories;

use App\Domains\Content\Enums\ContentCategoryEnum;
use App\Support\Repositories\Repository;

class SubcategoryRepository extends Repository
{
    protected string $model = \App\Domains\Content\Models\Subcategory::class;

    protected ?array $withCount = ['contents'];

    protected ?array $searchableColumns = ['name'];

    protected string $defaultSort = 'name';

    protected string $defaultSortDirection = self::SORT_DIRECTION_ASC;

    protected function category(?int $category): static
    {
        if (
            $category == ContentCategoryEnum::Motivation->value ||
            $category == ContentCategoryEnum::Reminder->value
        ) {
            $this->query->where('category', $category);
        }

        return $this;
    }
}
