<?php

declare(strict_types=1);

namespace App\Domains\Content\DataTransferObject;

use App\Domains\Content\Models\Content;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

class ContentData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $subcategory_id,
        public readonly ?string $title,
        public readonly string|Carbon|null $created_at,
        public readonly string|Carbon|null $updated_at,
    ) {}

    public static function fromModel(Content $model): self
    {
        return new self(
            id: $model->id,
            subcategory_id: $model->subcategory_id,
            title: $model->title,
            created_at: $model->created_at,
            updated_at: $model->updated_at,
        );
    }
}
