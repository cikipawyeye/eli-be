<?php

declare(strict_types=1);

namespace App\Support\Resource;

use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Support\Transformation\TransformationContextFactory;

class CursorPaginatedDataCollection extends \Spatie\LaravelData\CursorPaginatedDataCollection
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
