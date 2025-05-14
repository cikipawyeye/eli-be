<?php

declare(strict_types=1);

namespace App\Domains\Payment\States\Payment;

class Canceled extends PaymentState
{
    public static string $name = 'CANCELED';

    public static function stateLabel(): string
    {
        return __('app.canceled');
    }
}
