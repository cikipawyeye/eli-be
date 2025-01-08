<?php

declare(strict_types=1);

namespace App\Domains\Payment\DataTransferObjects\PaymentRequest;

use App\Domains\Payment\Enums\QRCodeChannelCode;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class QRCodeObjectData extends Data
{
    public function __construct(
        #[WithCast(EnumCast::class)]
        public QRCodeChannelCode $channel_code,
    ) {}
}
