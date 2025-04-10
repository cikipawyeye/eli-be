<?php

namespace App\Domains\Theme\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Wallpaper extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\WallpaperFactory> */
    use HasFactory;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'type'];

    protected static function newFactory(): Factory
    {
        return \Database\Factories\WallpaperFactory::new();
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('content')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        if (! $media) {
            return;
        }

        if ($media->getTypeFromMime() === 'video') {
            $this->addMediaConversion('thumb')
                ->format('webp')
                ->width(480)
                ->height(800)
                ->extractVideoFrameAtSecond(1)
                ->performOnCollections('content');
        } else {
            $this->addMediaConversion('thumb')
                ->format('webp')
                ->width(480)
                ->height(800)
                ->sharpen(10)
                ->performOnCollections('content');
        }
    }

    public function thumbnailUrl(): Attribute
    {
        $image = $this->getFirstMedia('content');
        if (! $image) {
            return Attribute::make(null);
        }

        $expiresAt = now()->addMinutes(30);

        return Attribute::make(fn() => URL::temporarySignedRoute(
            'api.wallpapers.thumbnail',
            $expiresAt,
            ['wallpaper' => $this->id]
        ));
    }

    public function fileUrl(): Attribute
    {
        $image = $this->getFirstMedia('content');
        if (! $image) {
            return Attribute::make(null);
        }

        $expiresAt = now()->addMinutes(30);

        return Attribute::make(fn() => URL::temporarySignedRoute(
            'api.wallpapers.file',
            $expiresAt,
            ['wallpaper' => $this->id]
        ));
    }
}
