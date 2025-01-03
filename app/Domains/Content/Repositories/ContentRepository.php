<?php

declare(strict_types=1);

namespace App\Domains\Content\Repositories;

use App\Domains\Content\Enums\ContentTypeEnum;
use App\Support\Repositories\Repository;

class ContentRepository extends Repository
{
    /** @var array<string>|null */
    protected ?array $searchableColumns = ['title'];

    protected string $defaultSort = 'title';

    protected string $defaultSortDirection = self::SORT_DIRECTION_ASC;

    /** @var array<string>|null */
    protected ?array $with = ['media'];

    protected string $model = \App\Domains\Content\Models\Content::class;

    protected function subcategory(?int $subcategory): static
    {
        if ($subcategory) {
            $this->query->where('subcategory_id', $subcategory);
        }

        return $this;
    }

    protected function type(?string $type): static
    {
        if ($type && in_array($type, ContentTypeEnum::toArray())) {
            $this->query->where('premium', $type == ContentTypeEnum::Premium->value);
        }

        return $this;
    }
}
