<?php

declare(strict_types=1);

namespace App\Domains\Payment\States\PaymentMethod;

class Expired extends PaymentMethodState
{
    public static string $name = 'EXPIRED';

    public static function stateLabel(): string
    {
        return __('app.expired');
    }
}
