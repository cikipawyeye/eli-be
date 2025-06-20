<?php

namespace App\Domains\Notification\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emotion extends Model
{
    /** @use HasFactory<\Database\Factories\EmotionFactory> */
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    protected static function newFactory(): Factory
    {
        return \Database\Factories\EmotionFactory::new();
    }
}
