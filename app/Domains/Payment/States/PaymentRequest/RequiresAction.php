<?php

declare(strict_types=1);

namespace App\Domains\Payment\States\PaymentRequest;

class RequiresAction extends PaymentRequestState
{
    public static string $name = 'REQUIRES_ACTION';

    public static function stateLabel(): string
    {
        return __('app.requires_action');
    }
}
