<?php

declare(strict_types=1);

namespace App\Domains\Content\Exceptions;

use App\Support\Exceptions\JsonResponseException;

class ContentException extends JsonResponseException
{
    public static function premiumContent(): self
    {
        return new static('This content is only available for premium users.', 403);
    }
}
