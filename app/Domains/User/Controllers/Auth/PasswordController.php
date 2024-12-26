<?php

declare(strict_types=1);

namespace App\Domains\User\Controllers\Auth;

use Illuminate\Http\Request;
use App\Domains\User\Enums\RoleEnum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Support\Controllers\Controller;
use Illuminate\Validation\Rules\Password;
use Illuminate\Routing\Controllers\Middleware;

class PasswordController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware(sprintf('role:%s|%s', RoleEnum::SuperAdmin->value, RoleEnum::Admin->value)),
        ];
    }
    
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back();
    }
}
