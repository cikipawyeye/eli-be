<?php

declare(strict_types=1);

namespace App\Domains\Payment\States\PaymentRequest;

class Failed extends PaymentRequestState
{
    public static string $name = 'FAILED';

    public static function stateLabel(): string
    {
        return __('app.failed');
    }
}
