<?php

declare(strict_types=1);

namespace App\Domains\User;

use App\Domains\User\Constants\PermissionConstant as P;
use App\Domains\User\Enums\RoleEnum as R;

class PermissionAssignment
{
    /**
     * @return array<string, string[]>
     */
    public static function assignments(): array // NOSONAR
    {
        return [
            P::VIEW_ADMIN_DASHBOARD => [
                R::SuperAdmin,
                R::Admin,
            ],

            P::MANAGE_SUBCATEGORIES => [
                R::SuperAdmin,
                R::Admin,
            ],
            P::BROWSE_SUBCATEGORIES => [
                R::SuperAdmin,
                R::Admin,
                R::User,
            ],
            P::READ_SUBCATEGORY => [
                R::SuperAdmin,
                R::Admin,
                R::User,
            ],
            P::EDIT_SUBCATEGORY => [
                R::SuperAdmin,
                R::Admin,
            ],
            P::ADD_SUBCATEGORY => [
                R::SuperAdmin,
                R::Admin,
            ],
            P::DELETE_SUBCATEGORY => [
                R::SuperAdmin,
                R::Admin,
            ],
        ];
    }

    public static function getPermissionsByRole(string $role): array
    {
        $permissions = [];

        foreach (self::assignments() as $permission => $roles) {
            if (in_array($role, array_map(fn (R $role) => $role->value, $roles), true)) {
                $permissions[] = $permission;
            }
        }

        return $permissions;
    }
}
