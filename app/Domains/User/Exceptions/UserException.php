<?php

declare(strict_types=1);

namespace App\Domains\User\Exceptions;

use App\Support\Exceptions\AbstractException;

class UserException extends AbstractException
{
    public static function cannotUpdateAdminToUser(): self
    {
        return new self('You cannot update this user.', 422);
    }
}
