<?php

declare(strict_types=1);

namespace App\Domains\Content\Models;

use App\Support\Models\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\URL;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\ResponsiveImages\ResponsiveImage;

/**
 * @mixin IdeHelperContent
 */
class Content extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];

    protected static function newFactory(): Factory
    {
        return \Database\Factories\ContentFactory::new();
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('content')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('optimized')
            ->format('jpg')
            ->performOnCollections('content')
            ->withResponsiveImages();
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    // Set the image urls
    public function imageUrls(): Attribute
    {
        $image = $this->getFirstMedia('content');
        if (! $image) {
            return Attribute::make(null);
        }

        $expiresAt = now()->addMinutes(30);
        $baseUrl = URL::temporarySignedRoute(
            'contents.image',
            $expiresAt,
            ['content' => $this->id]
        );
        $originalUrl = $baseUrl;
        $optimizedUrl = sprintf('%s&type=optimized', $baseUrl);
        /** @var \Illuminate\Support\Collection<ResponsiveImage> */
        $responsiveImages = $image?->responsiveImages('optimized')->files ?? collect();
        $responsives = $responsiveImages->map(fn (ResponsiveImage $file) => [
            'width' => $file->width(),
            'height' => $file->height(),
            'url' => sprintf('%s&type=%s', $baseUrl, sprintf('responsive/%s', $file->fileName)),
        ])->toArray();

        return Attribute::make(fn () => [
            'original' => $originalUrl,
            'optimized' => $optimizedUrl,
            'responsives' => $responsives,
            'alt' => $this->title,
        ]);
    }
}
