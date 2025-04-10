<?php

declare(strict_types=1);

namespace App\Domains\User\Constants;

use App\Support\Constants\Constant;

class PermissionConstant extends Constant
{
    public const VIEW_HORIZON_DASHBOARD = 'view_horizon_dashboard';
    public const VIEW_ADMIN_DASHBOARD = 'view_admin_dashboard';

    // user
    public const MANAGE_USERS = 'manage_users';
    public const BROWSE_USERS = 'browse_users';
    public const READ_USER = 'read_user';
    public const EDIT_USER = 'edit_user';
    public const ADD_USER = 'add_user';
    public const DELETE_USER = 'delete_user';

    // subcategory
    public const MANAGE_SUBCATEGORIES = 'manage_subcategories';
    public const BROWSE_SUBCATEGORIES = 'browse_subcategories';
    public const READ_SUBCATEGORY = 'read_subcategory';
    public const EDIT_SUBCATEGORY = 'edit_subcategory';
    public const ADD_SUBCATEGORY = 'add_subcategory';
    public const DELETE_SUBCATEGORY = 'delete_subcategory';

    // content
    public const MANAGE_CONTENTS = 'manage_contents';
    public const BROWSE_CONTENTS = 'browse_contents';
    public const READ_CONTENT = 'read_content';
    public const EDIT_CONTENT = 'edit_content';
    public const ADD_CONTENT = 'add_content';
    public const DELETE_CONTENT = 'delete_content';

    // payment
    public const MANAGE_PAYMENTS = 'manage_payments';
    public const BROWSE_PAYMENTS = 'browse_payments';
    public const READ_PAYMENT = 'read_payment';
    public const EDIT_PAYMENT = 'edit_payment';
    public const ADD_PAYMENT = 'add_payment';
    public const DELETE_PAYMENT = 'delete_payment';

    // wallpaper
    public const MANAGE_WALLPAPERS = 'manage_wallpapers';
    public const BROWSE_WALLPAPERS = 'browse_wallpapers';
    public const READ_WALLPAPER = 'read_wallpaper';
    public const EDIT_WALLPAPER = 'edit_wallpaper';
    public const ADD_WALLPAPER = 'add_wallpaper';
    public const DELETE_WALLPAPER = 'delete_wallpaper';
}
