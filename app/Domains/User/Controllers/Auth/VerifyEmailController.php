<?php

declare(strict_types=1);

namespace App\Domains\User\Controllers\Auth;

use App\Domains\User\Enums\RoleEnum;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use App\Support\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware(sprintf('role:%s|%s', RoleEnum::SuperAdmin->value, RoleEnum::Admin->value)),
        ];
    }
    
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
