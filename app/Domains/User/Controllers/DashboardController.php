<?php

declare(strict_types=1);

namespace App\Domains\User\Controllers;

use App\Domains\User\Repositories\DashboardRepository;
use App\Support\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $range = $request->get('range');

        $since = match ($range) {
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'year' => now()->startOfYear(),
            default => now()->subDay()->startOfDay(),
        };

        $until = match ($range) {
            'week' => now()->endOfWeek(),
            'month' => now()->endOfMonth(),
            'year' => now()->endOfYear(),
            default => now()->subDay()->endOfDay(),
        };

        $repo = new DashboardRepository($since, $until);

        return inertia('User/Dashboard/Dashboard', [
            'premiumUser' => Inertia::defer(fn () => $repo->getPremiumUser()),
            'nonPremiumUser' => Inertia::defer(fn () => $repo->getNonPremiumUser()),
            'averageAge' => Inertia::defer(fn () => $repo->getUserAverageAge()),
            'ageStats' => Inertia::defer(fn () => $repo->getAgeStats()),
            'genderStats' => Inertia::defer(fn () => $repo->getGenderStats()),
            'revenue' => Inertia::defer(fn () => $repo->getRevenue()),
            'topCities' => Inertia::defer(fn () => $repo->getTopCities($request->get('city_cursor'))),
        ]);
    }
}
