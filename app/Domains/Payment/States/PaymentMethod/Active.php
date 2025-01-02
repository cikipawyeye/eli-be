<?php

declare(strict_types=1);

namespace App\Domains\Payment\States\PaymentMethod;

class Active extends PaymentMethodState
{
    public static string $name = 'ACTIVE';

    public static function stateLabel(): string
    {
        return __('app.active');
    }
}
