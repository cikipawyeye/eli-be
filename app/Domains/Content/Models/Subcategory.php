<?php

namespace App\Domains\Content\Models;

use App\Support\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class Subcategory extends Model
{

    protected static function newFactory(): Factory
    {
        return \Database\Factories\SubcategoryFactory::new();
    }
}
