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
        public readonly ?bool $premium,
        public readonly Lazy|int|null $contents_count,
        public readonly Lazy|string|null $category_name,
    ) {}

    public static function fromModel(Subcategory $model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
            category: $model->category,
            is_active: $model->is_active,
            premium: $model->premium,
            contents_count: Lazy::create(fn () => $model->contents_count),
            category_name: Lazy::create(fn () => 0 == $model->category ? __('app.motivation') : __('app.reminder')),
        );
    }
}
