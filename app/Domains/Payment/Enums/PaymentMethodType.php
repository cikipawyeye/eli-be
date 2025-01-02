<?php

declare(strict_types=1);

namespace App\Domains\Payment\Enums;

use App\Support\Traits\EnumTrait;
use Xendit\PaymentMethod\PaymentMethodType as X;

enum PaymentMethodType: string
{
    use EnumTrait;

    case VIRTUAL_ACCOUNT = X::VIRTUAL_ACCOUNT;
    case OVER_THE_COUNTER = X::OVER_THE_COUNTER;
    case QR_CODE = X::QR_CODE;
    case EWALLET = X::EWALLET;
}
