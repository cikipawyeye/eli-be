<?php

namespace App\Domains\Notification\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    /** @use HasFactory<\Database\Factories\MessageFactory> */
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'content',
    ];

    protected static function newFactory(): Factory
    {
        return \Database\Factories\MessageFactory::new();
    }

    public function emotion(): BelongsTo
    {
        return $this->belongsTo(Emotion::class);
    }
}
