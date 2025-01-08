<?php

declare(strict_types=1);

namespace App\Domains\Payment\DataTransferObjects\PaymentRequest;

use App\Domains\Payment\Enums\EWalletChannelCode;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class EWalletObjectData extends Data
{
    public function __construct(
        #[WithCast(EnumCast::class)]
        public EWalletChannelCode $channel_code,
        public ?string $phone_number,
    ) {}
}
