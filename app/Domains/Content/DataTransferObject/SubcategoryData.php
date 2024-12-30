<?php

declare(strict_types=1);

namespace App\Domains\Content\DataTransferObject;

use App\Domains\Content\Enums\ContentCategoryEnum;
use App\Domains\Content\Models\Subcategory;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class SubcategoryData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $name,
        public readonly string|ContentCategoryEnum|null $category,
        public readonly ?bool $is_active,
        public readonly Lazy|int|null $contents_count,
    ) {}

    public static function fromModel(Subcategory $model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
            category: $model->category,
            is_active: $model->is_active,
            contents_count: Lazy::create(fn() => $model->contents_count),
        );
    }
}
