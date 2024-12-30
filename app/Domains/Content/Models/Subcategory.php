<?php

namespace App\Domains\Content\Models;

use App\Support\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class Subcategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'category', 'is_active'];

    protected static function newFactory(): Factory
    {
        return \Database\Factories\SubcategoryFactory::new();
    }
}
