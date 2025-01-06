<?php

declare(strict_types=1);

namespace App\Domains\Payment\States\Payment;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class PaymentState extends State
{
    abstract public static function stateLabel(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Failed::class, Pending::class)
            ->allowTransition(Failed::class, Succeeded::class)
            ->allowTransition(Succeeded::class, Pending::class)
            ->allowTransition(Succeeded::class, Failed::class)
            ->allowTransition(Pending::class, Succeeded::class)
            ->allowTransition(Pending::class, Failed::class);
    }
}
