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
            P::VIEW_HORIZON_DASHBOARD => [R::SuperAdmin],
            P::VIEW_ADMIN_DASHBOARD => [
                R::SuperAdmin,
                R::Admin,
            ],

            // Subcategory
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

            // Content
            P::MANAGE_CONTENTS => [
                R::SuperAdmin,
                R::Admin,
            ],
            P::BROWSE_CONTENTS => [
                R::SuperAdmin,
                R::Admin,
                R::User,
            ],
            P::READ_CONTENT => [
                R::SuperAdmin,
                R::Admin,
                R::User,
            ],
            P::EDIT_CONTENT => [
                R::SuperAdmin,
                R::Admin,
            ],
            P::ADD_CONTENT => [
                R::SuperAdmin,
                R::Admin,
            ],
            P::DELETE_CONTENT => [
                R::SuperAdmin,
                R::Admin,
            ],

            // User
            P::MANAGE_USERS => [
                R::SuperAdmin,
                R::Admin,
            ],
            P::BROWSE_USERS => [
                R::SuperAdmin,
                R::Admin,
            ],
            P::READ_USER => [
                R::SuperAdmin,
                R::Admin,
            ],
            P::EDIT_USER => [
                R::SuperAdmin,
            ],
            P::ADD_USER => [
                R::SuperAdmin,
            ],
            P::DELETE_USER => [
                R::SuperAdmin,
            ],

            // Payment
            P::MANAGE_PAYMENTS => [
                R::SuperAdmin,
                R::Admin,
            ],
            P::BROWSE_PAYMENTS => [
                R::SuperAdmin,
                R::Admin,
                R::User,
            ],
            P::READ_PAYMENT => [
                R::SuperAdmin,
                R::Admin,
                R::User,
            ],
            P::EDIT_PAYMENT => [
                R::SuperAdmin,
            ],
            P::ADD_PAYMENT => [
                R::SuperAdmin,
            ],
            P::DELETE_PAYMENT => [
                R::SuperAdmin,
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
