<?php

declare(strict_types=1);

namespace App\Domains\Content\Models;

use App\Support\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperSubcategory
 */
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

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }
}
