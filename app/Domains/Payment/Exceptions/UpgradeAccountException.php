<?php

declare(strict_types=1);

namespace App\Domains\Payment\Exceptions;

use App\Support\Exceptions\JsonResponseException;

class UpgradeAccountException extends JsonResponseException {
    public static function alreadyPremium(): self
    {
        return new self('Your account is already premium', 422);
    }
}
