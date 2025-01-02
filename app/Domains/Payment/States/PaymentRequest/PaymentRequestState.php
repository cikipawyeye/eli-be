<?php

declare(strict_types=1);

namespace App\Domains\Payment\States\PaymentRequest;

use Spatie\ModelStates\State;

abstract class PaymentRequestState extends State
{
    abstract public static function stateLabel(): string;
}
