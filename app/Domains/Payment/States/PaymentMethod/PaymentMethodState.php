<?php

declare(strict_types=1);

namespace App\Domains\Payment\States\PaymentMethod;

use Spatie\ModelStates\State;

abstract class PaymentMethodState extends State
{
    abstract public static function stateLabel(): string;
}
