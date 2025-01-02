<?php

declare(strict_types=1);

namespace App\Domains\Payment\States\Payment;

class Succeeded extends PaymentState
{
    public static string $name = 'SUCCEEDED';

    public static function stateLabel(): string
    {
        return __('app.succeeded');
    }
}
