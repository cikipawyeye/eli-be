<?php

namespace App\Domains\Theme\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Music extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\MusicFactory> */
    use HasFactory;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];

    protected static function newFactory(): Factory
    {
        return \Database\Factories\MusicFactory::new();
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('content')
            ->singleFile();
    }

    public function fileUrl(): Attribute
    {
        $file = $this->getFirstMedia('content');
        if (! $file) {
            return Attribute::make(null);
        }

        $expiresAt = now()->addMinutes(30);

        return Attribute::make(fn() => URL::temporarySignedRoute(
            'api.musics.file',
            $expiresAt,
            ['music' => $this->id]
        ));
    }
}
