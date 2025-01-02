<?php

declare(strict_types=1);

namespace App\Domains\Payment\States\Payment;

use Spatie\ModelStates\State;

abstract class PaymentState extends State
{
    abstract public static function stateLabel(): string;
}
