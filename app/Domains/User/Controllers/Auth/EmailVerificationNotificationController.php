<?php

declare(strict_types=1);

namespace App\Domains\User\Controllers\Auth;

use App\Domains\User\Enums\RoleEnum;
use App\Support\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(sprintf('role:%s|%s', RoleEnum::Admin->value, RoleEnum::SuperAdmin->value));
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
