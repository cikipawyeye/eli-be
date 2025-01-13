<?php

declare(strict_types=1);

namespace App\Domains\Payment\Exceptions;

use App\Support\Exceptions\JsonResponseException;

class PaymentException extends JsonResponseException
{
    public static function invalidPaymentType(): self
    {
        return new self('Selected payment type is invalid.', 422);
    }

    public static function notFound(): self
    {
        return new self('Payment not found.', 404);
    }
}
