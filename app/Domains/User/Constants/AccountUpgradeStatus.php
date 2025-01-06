<?php

declare(strict_types=1);

namespace App\Domains\User\Constants;

use App\Support\Constants\Constant;

class AccountUpgradeStatus extends Constant
{
    public const PREMIUM = 'PREMIUM';
    public const NOT_PREMIUM = 'NOT_PREMIUM';
    public const PENDING_PAYMENT = 'PENDING_PAYMENT';
}
