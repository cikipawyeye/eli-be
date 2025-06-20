<?php

namespace App\Domains\Notification\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReminderNotification extends Model
{
    /** @use HasFactory<\Database\Factories\ReminderNotificationFactory> */
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'message', 'is_active'];

    protected static function newFactory(): Factory
    {
        return \Database\Factories\ReminderNotificationFactory::new();
    }
}
