<?php

declare(strict_types=1);

namespace App\Domains\Payment\Enums;

use App\Support\Traits\EnumTrait;
use Xendit\PaymentRequest\VirtualAccountChannelCode as X;

enum VirtualAccountChannelCode: string
{
    use EnumTrait;

    case BCA = X::BCA;
    case BRI = X::BRI;
    case BNI = X::BNI;
    case MANDIRI = X::MANDIRI;
    case BSI = X::BSI;
    case BJB = X::BJB;
    case CIMB = X::CIMB;
    case SAHABAT_SAMPOERNA = X::SAHABAT_SAMPOERNA;
    case PERMATA = X::PERMATA;

    public function translated(): string
    {
        return __(
            sprintf('banks.%s', sprintf('ID_%s', $this->value))
        );
    }
}
