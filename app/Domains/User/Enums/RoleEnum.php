<?php

declare(strict_types=1);

namespace App\Domains\User\Enums;

use App\Support\Traits\EnumTrait;

enum RoleEnum: string
{
    use EnumTrait;

    case User = 'user';
    case SuperAdmin = 'super_admin';
    case Admin = 'admin';

    public function translated(): string
    {
        return match ($this->value) {
            self::User->value => 'User',
            self::SuperAdmin->value => 'Super Admin',
            self::Admin->value => 'Admin',
            default => $this->name,
        };
    }
}
