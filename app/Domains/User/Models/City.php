<?php

declare(strict_types=1);

namespace App\Domains\User\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravolt\Indonesia\Models\City as BaseCityModel;

/**
 * @mixin IdeHelperCity
 */
class City extends BaseCityModel
{
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'city_code', 'code');
    }
}
