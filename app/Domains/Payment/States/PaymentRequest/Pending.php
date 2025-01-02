<?php

declare(strict_types=1);

namespace App\Domains\Payment\States\PaymentRequest;

class Pending extends PaymentRequestState
{
    public static string $name = 'PENDING';

    public static function stateLabel(): string
    {
        return __('app.pending');
    }
}
