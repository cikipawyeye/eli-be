<?php

declare(strict_types=1);

namespace App\Domains\Payment\DataTransferObjects\PaymentRequest;

use App\Domains\Payment\Enums\OverTheCounterChannelCode;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class OverTheCounterObjectData extends Data
{
    public function __construct(
        #[WithCast(EnumCast::class)]
        public OverTheCounterChannelCode $channel_code,
    ) {}
}
