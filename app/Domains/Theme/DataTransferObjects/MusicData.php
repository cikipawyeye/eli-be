<?php

namespace App\Domains\Theme\DataTransferObjects;

use App\Domains\Theme\Models\Music;
use Spatie\LaravelData\Data;

class MusicData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        public readonly ?string $file_url,
    ) {}

    public static function fromModel(Music $music)
    {
        return new self(
            id: $music->id,
            title: $music->title,
            file_url: $music->file_url,
        );
    }
}
