<?php

declare(strict_types=1);

namespace App\Domains\User\Controllers\Auth;

use Illuminate\Http\Request;
use App\Domains\User\Enums\RoleEnum;
use Illuminate\Http\RedirectResponse;
use App\Support\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;

class EmailVerificationNotificationController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware(sprintf('role:%s|%s', RoleEnum::SuperAdmin->value, RoleEnum::Admin->value)),
        ];
    }

    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
