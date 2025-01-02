<?php

declare(strict_types=1);

namespace App\Domains\Payment\States\PaymentMethod;

class Failed extends PaymentMethodState
{
    public static string $name = 'FAILED';

    public static function stateLabel(): string
    {
        return __('app.failed');
    }
}
