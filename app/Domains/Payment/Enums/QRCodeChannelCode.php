<?php

declare(strict_types=1);

namespace App\Domains\Payment\Enums;

use App\Support\Traits\EnumTrait;
use Xendit\PaymentRequest\QRCodeChannelCode as X;

enum QRCodeChannelCode: string
{
    use EnumTrait;

    case QRIS = X::QRIS;

    public function translated(): string
    {
        return match ($this->value) {
            X::QRIS => 'QRIS',
        };
    }
}
