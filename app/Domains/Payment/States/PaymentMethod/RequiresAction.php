<?php

declare(strict_types=1);

namespace App\Domains\Payment\States\PaymentMethod;

class RequiresAction extends PaymentMethodState
{
    public static string $name = 'REQUIRES_ACTION';

    public static function stateLabel(): string
    {
        return __('app.requires_action');
    }
}
