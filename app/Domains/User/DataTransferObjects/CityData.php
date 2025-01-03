<?php

namespace App\Domains\User\DataTransferObjects;

use Laravolt\Indonesia\Models\City;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class CityData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $code,
        public readonly ?string $province_code,
        public readonly ?array $meta,
        public readonly Lazy|ProvinceData|null $province,
    ) {}

    public static function fromModel(City $model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
            code: $model->code,
            province_code: $model->province_code,
            meta: $model->meta,
            province: Lazy::create(fn() => ProvinceData::fromModel($model->province)),
        );
    }
}
