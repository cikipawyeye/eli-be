<?php

declare(strict_types=1);

namespace App\Domains\Payment\States\PaymentRequest;

class AwaitingCapture extends PaymentRequestState
{
    public static string $name = 'AWAITING_CAPTURE';

    public static function stateLabel(): string
    {
        return __('app.awaiting_capture');
    }
}
