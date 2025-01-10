<?php

namespace App\Domains\User\Repositories;

use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\States\Payment\Succeeded;
use App\Domains\User\Enums\GenderEnum;
use App\Domains\User\Enums\RoleEnum;
use App\Domains\User\Models\City;
use App\Domains\User\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    public function __construct(
        private readonly Carbon $since,
        private readonly Carbon $until
    ) {}

    public function getRevenue(): array
    {
        $interval = $this->since->diff($this->until);

        $previousSince = $this->since->copy()->sub($interval);
        $previousUntil = $this->until->copy()->sub($interval);

        $revenues = Payment::where('state', Succeeded::$name)
            ->selectRaw("
            SUM(CASE WHEN updated_at BETWEEN ? AND ? THEN amount ELSE 0 END) AS current,
            SUM(CASE WHEN updated_at BETWEEN ? AND ? THEN amount ELSE 0 END) AS previous
        ", [
                $this->since,
                $this->until, // Periode saat ini
                $previousSince,
                $previousUntil // Periode sebelumnya
            ])
            ->first();

        return [
            'current' => $revenues->current ?? 0,
            'previous' => $revenues->previous ?? 0,
        ];
    }

    public function getPremiumUser(): int
    {
        return User::role(RoleEnum::User->value)
            ->where('is_premium', true)
            ->count();
    }

    public function getNonPremiumUser(): int
    {
        return User::role(RoleEnum::User->value)
            ->where('is_premium', false)
            ->count();
    }

    public function getUserAverageAge(): ?float
    {
        return User::selectRaw('AVG(DATE_PART(\'year\', AGE(birth_date))) as average_age')
            ->value('average_age');
    }

    public function getAgeStats(): array
    {
        $ageRanges = User::selectRaw("
            COUNT(CASE WHEN DATE_PART('year', AGE(birth_date)) < 18 THEN 1 END) AS range0,
            COUNT(CASE WHEN DATE_PART('year', AGE(birth_date)) BETWEEN 18 AND 25 THEN 1 END) AS range1,
            COUNT(CASE WHEN DATE_PART('year', AGE(birth_date)) BETWEEN 26 AND 35 THEN 1 END) AS range2,
            COUNT(CASE WHEN DATE_PART('year', AGE(birth_date)) BETWEEN 36 AND 45 THEN 1 END) AS range3,
            COUNT(CASE WHEN DATE_PART('year', AGE(birth_date)) BETWEEN 46 AND 55 THEN 1 END) AS range4,
            COUNT(CASE WHEN DATE_PART('year', AGE(birth_date)) > 55 THEN 1 END) AS range5
        ")->first();

        return $ageRanges->toArray();
    }

    public function getGenderStats(): array
    {
        $genderStats = User::role(RoleEnum::User->value)
            ->selectRaw("
                COUNT(CASE WHEN gender = ? THEN 1 END) AS male,
                COUNT(CASE WHEN gender = ? THEN 1 END) AS female,
                COUNT(CASE WHEN gender IS NULL THEN 1 END) AS unknown
            ", [GenderEnum::Male->value, GenderEnum::Female->value])
            ->first();

        return $genderStats->toArray();
    }

    public function getTopCities(?string $cursor = null): CursorPaginator
    {
        $adminIds = User::role([RoleEnum::Admin->value, RoleEnum::SuperAdmin->value])
            ->pluck('id');

        $cityStats = City::rightJoin('users', 'indonesia_cities.code', '=', 'users.city_code')
            ->select('indonesia_cities.code', 'indonesia_cities.name', DB::raw('COUNT(DISTINCT users.id) as users_count'))
            ->whereNull('users.deleted_at')
            ->whereNotIn('users.id', $adminIds)
            ->groupBy('indonesia_cities.id')
            ->orderBy('users_count', 'desc')
            ->orderBy('indonesia_cities.name', 'asc');

        return $cityStats->cursorPaginate(perPage: 6, cursor: $cursor);
    }
}
