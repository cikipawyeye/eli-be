<?php

declare(strict_types=1);

namespace App\Domains\Payment\States\PaymentMethod;

class Inactive extends PaymentMethodState
{
    public static string $name = 'INACTIVE';

    public static function stateLabel(): string
    {
        return __('app.inactive');
    }
}
