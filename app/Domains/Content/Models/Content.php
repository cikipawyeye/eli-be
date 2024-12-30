<?php

declare(strict_types=1);

namespace App\Domains\Content\Models;

use App\Support\Models\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
        $this->addMediaConversion('webp')
            ->format('webp')
            ->performOnCollections('content')
            ->withResponsiveImages();
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    // Set the image urls
    // public function image(): Attribute
    // {
    //     $image = $this->getFirstMedia('content');
    //     return Attribute::make(fn () => $image ? [
    //         'original_url' => $image->getFullUrl(),
    //         'optimized_url' => $image->getFullUrl('webp'),
    //         'responsive' => $image->getResponsiveImageUrls('webp'),
    //         'alt' => $this->title,
    //     ] : null);
    // }
}
