<?php

namespace App\Domains\User\Controllers;

use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\States\Payment\Succeeded;
use App\Domains\User\Enums\GenderEnum;
use App\Domains\User\Enums\RoleEnum;
use App\Domains\User\Models\User;
use App\Support\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // TODO: Add filter for date range
    public function __invoke(Request $request)
    {
        $revenue = Payment::where('state', Succeeded::$name)->sum('amount');
        $averageAge = User::selectRaw('AVG(EXTRACT(YEAR FROM AGE(birth_date))) as average_age')
            ->value('average_age');
        $premiumUser = User::role(RoleEnum::User->value)->where('is_premium', true)->count();
        $nonPremiumUser = User::role(RoleEnum::User->value)->where('is_premium', false)->count();
        $range0 = User::whereRaw("DATE_PART('year', AGE(birth_date)) < 18")->count();
        $range1 = User::whereRaw("DATE_PART('year', AGE(birth_date)) BETWEEN 18 AND 25")->count();
        $range2 = User::whereRaw("DATE_PART('year', AGE(birth_date)) BETWEEN 25 AND 35")->count();
        $range3 = User::whereRaw("DATE_PART('year', AGE(birth_date)) BETWEEN 36 AND 45")->count();
        $range4 = User::whereRaw("DATE_PART('year', AGE(birth_date)) BETWEEN 46 AND 55")->count();
        $range5 = User::whereRaw("DATE_PART('year', AGE(birth_date)) > 55")->count();
        $maleUser = User::role(RoleEnum::User->value)->where('gender', GenderEnum::Male->value)->count();
        $femaleUser = User::role(RoleEnum::User->value)->where('gender', GenderEnum::Female->value)->count();
        $unknownGenderUser = User::role(RoleEnum::User->value)->where('gender', null)->count();

        return inertia('User/Dashboard/Dashboard', [
            'revenue' => $revenue,
            'premiumUser' => $premiumUser,
            'nonPremiumUser' => $nonPremiumUser,
            'averageAge' => $averageAge,
            'ageStats' => [
                'range0' => $range0,
                'range1' => $range1,
                'range2' => $range2,
                'range3' => $range3,
                'range4' => $range4,
                'range5' => $range5
            ],
            'genderStats' => [
                'male' => $maleUser,
                'female' => $femaleUser,
                'unknown' => $unknownGenderUser,
            ],
        ]);
    }
}
