<?php

namespace App\Domains\Theme\DataTransferObjects;

use App\Domains\Theme\Models\Wallpaper;
use Spatie\LaravelData\Data;

class WallpaperData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $type,
        public readonly ?string $thumbnail_url,
        public readonly ?string $file_url,
    ) {}

    public static function fromModel(Wallpaper $wallpaper)
    {
        return new self(
            id: $wallpaper->id,
            name: $wallpaper->name,
            type: $wallpaper->type,
            thumbnail_url: $wallpaper->thumbnail_url,
            file_url: $wallpaper->file_url,
        );
    }
}
