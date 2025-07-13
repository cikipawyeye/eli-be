<?php

declare(strict_types=1);

namespace App\Domains\Notification\Exceptions;

use App\Support\Exceptions\JsonResponseException;

class ReminderNotificationException extends JsonResponseException
{
    public static function noActiveNotification(): self
    {
        return new self('No active reminder notification found.', 404);
    }
}
