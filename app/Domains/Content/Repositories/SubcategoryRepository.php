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

    protected function type(?string $type): static
    {
        if (
            'active' == $type ||
            'inactive' == $type
        ) {
            $this->query->where('is_active', 'active' == $type);
        }

        return $this;
    }

    protected function access(?string $access): static
    {
        if (
            'premium' == $access ||
            'non_premium' == $access
        ) {
            $this->query->where('premium', 'premium' == $access);
        }

        return $this;
    }

    protected function hasContentOnly(?bool $value): static
    {
        if ($value) {
            $this->query->whereHas('contents');
        }

        return $this;
    }
}
