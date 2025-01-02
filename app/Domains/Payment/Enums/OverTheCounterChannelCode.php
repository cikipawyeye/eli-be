<?php

declare(strict_types=1);

namespace App\Domains\Payment\Enums;

use App\Support\Traits\EnumTrait;
use Xendit\PaymentRequest\OverTheCounterChannelCode as X;

enum OverTheCounterChannelCode: string
{
    use EnumTrait;

    case INDOMARET = X::INDOMARET;
    case ALFAMART = X::ALFAMART;
}
