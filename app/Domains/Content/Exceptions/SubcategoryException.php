<?php

declare(strict_types=1);

namespace App\Domains\Content\Exceptions;

use App\Support\Exceptions\JsonResponseException;
use Symfony\Component\HttpFoundation\Response;

class SubcategoryException extends JsonResponseException
{
    public static function invalidCategory(): self
    {
        return new static(
            'Invalid category',
            Response::HTTP_NOT_FOUND
        );
    }
}
