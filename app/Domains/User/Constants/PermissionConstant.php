<?php

declare(strict_types=1);

namespace App\Domains\User\Constants;

use App\Support\Constants\Constant;

class PermissionConstant extends Constant
{
    public const VIEW_ADMIN_DASHBOARD = 'view_admin_dashboard';

    // user
    public const MANAGE_USERS = 'manage_users';
    public const BROWSE_USERS = 'browse_users';
    public const READ_USER = 'read_user';
    public const EDIT_USER = 'edit_user';
    public const ADD_USER = 'add_user';
    public const DELETE_USER = 'delete_user';
}
