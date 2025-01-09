<?php

namespace App\Domains\User\Controllers;

use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\States\Payment\Succeeded;
use App\Domains\User\Enums\RoleEnum;
use App\Domains\User\Models\User;
use App\Support\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $revenue = Payment::where('state', Succeeded::$name)->sum('amount');
        $averageAge = User::selectRaw('AVG(EXTRACT(YEAR FROM AGE(birth_date))) as average_age')
            ->value('average_age');
        $premiumUser = User::role(RoleEnum::User->value)->where('is_premium', true)->count();
        $nonPremiumUser = User::role(RoleEnum::User->value)->where('is_premium', false)->count();

        return inertia('User/Dashboard/Dashboard', [
            'revenue' => $revenue,
            'premiumUser' => $premiumUser,
            'nonPremiumUser' => $nonPremiumUser,
            'averageAge' => $averageAge,
        ]);
    }
}
