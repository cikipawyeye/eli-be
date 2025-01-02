<?php

declare(strict_types=1);

namespace App\Domains\Payment\Enums;

use App\Support\Traits\EnumTrait;
use Xendit\PaymentRequest\EWalletChannelCode as X;

enum EWalletChannelCode: string
{
    use EnumTrait;

    case DANA = X::DANA;
    case LINKAJA = X::LINKAJA;
    case OVO = X::OVO;
    // case SHOPEEPAY = X::SHOPEEPAY;

    public function translated(): string
    {
        return match ($this->value) {
            X::DANA => 'Dana',
            X::LINKAJA => 'LinkAja',
            X::OVO => 'OVO',
            // X::SHOPEEPAY => 'ShopeePay',
        };
    }
}
