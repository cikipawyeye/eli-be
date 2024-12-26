<?php

declare(strict_types=1);

namespace App\Support\Resource;

use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Support\Transformation\TransformationContextFactory;

class PaginatedDataCollection extends \Spatie\LaravelData\PaginatedDataCollection
{
    public function transform(
        null|TransformationContextFactory|TransformationContext $transformationContext = null,
    ): array {
        $data = parent::transform();

        $meta = $data['meta'] ?? [];

        unset($data['meta']);

        return array_merge($data, $meta);
    }
}
