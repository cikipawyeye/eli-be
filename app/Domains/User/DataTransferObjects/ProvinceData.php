<?php

namespace App\Domains\User\DataTransferObjects;

use Laravolt\Indonesia\Models\Province;
use Spatie\LaravelData\Data;

class ProvinceData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $code,
        public readonly string $name,
        public readonly ?array $meta,
    ) {}

    public static function fromModel(Province $model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
            code: $model->code,
            meta: $model->meta,
        );
    }
}
