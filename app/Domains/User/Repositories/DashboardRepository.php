<?php

namespace App\Domains\User\Repositories;

use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\States\Payment\Succeeded;
use App\Domains\User\Enums\GenderEnum;
use App\Domains\User\Enums\RoleEnum;
use App\Domains\User\Models\User;
use Carbon\Carbon;

class DashboardRepository
{
    public function __construct(
        private readonly Carbon $since,
        private readonly Carbon $until
    ) {}

    public function getRevenue(): array
    {
        $interval = $this->since->diff($this->until);

        $currentRevenue = Payment::where('state', Succeeded::$name)
            ->whereBetween('updated_at', [$this->since, $this->until])
            ->sum('amount');

        $previousSince = $this->since->copy()->sub($interval);
        $previousUntil = $this->until->copy()->sub($interval);
    
        $previousRevenue = Payment::where('state', Succeeded::$name)
            ->whereBetween('updated_at', [$previousSince, $previousUntil])
            ->sum('amount');
    
        return [
            'current' => $currentRevenue,
            'previous' => $previousRevenue,
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
        return User::selectRaw('AVG(EXTRACT(YEAR FROM AGE(birth_date))) as average_age')
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
}
