<?php

declare(strict_types=1);

namespace App\Domains\User\Controllers\Auth;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Domains\User\Enums\RoleEnum;
use Illuminate\Http\RedirectResponse;
use App\Support\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;

class EmailVerificationPromptController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware(sprintf('role:%s|%s', RoleEnum::SuperAdmin->value, RoleEnum::Admin->value)),
        ];
    }
    
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('dashboard', absolute: false))
                    : Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }
}
