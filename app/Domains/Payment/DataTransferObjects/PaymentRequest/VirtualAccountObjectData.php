<?php

declare(strict_types=1);

namespace App\Domains\Payment\DataTransferObjects\PaymentRequest;

use App\Domains\Payment\Enums\VirtualAccountChannelCode;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class VirtualAccountObjectData extends Data
{
    public function __construct(
        #[WithCast(EnumCast::class)]
        public VirtualAccountChannelCode $channel_code,
    ) {}
}
