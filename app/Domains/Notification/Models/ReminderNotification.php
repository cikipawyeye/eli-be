<?php

namespace App\Domains\Notification\Models;

use App\Support\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ReminderNotification extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'message', 'is_active', 'notification_time'];

    protected static function newFactory(): Factory
    {
        return \Database\Factories\ReminderNotificationFactory::new();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('optimized')
            ->format('webp')
            ->performOnCollections('image');
    }
}
