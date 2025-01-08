<?php

declare(strict_types=1);

namespace App\Domains\Payment\DataTransferObjects\PaymentRequest;

use App\Domains\Payment\Enums\PaymentMethodType as Type;
use App\Domains\Payment\Requests\API\CreatePaymentRequest;
use App\Domains\Payment\Enums\OverTheCounterChannelCode;
use App\Domains\Payment\Enums\EWalletChannelCode;
use App\Domains\Payment\Enums\QRCodeChannelCode;
use App\Domains\Payment\Enums\VirtualAccountChannelCode;
use App\Domains\Payment\Exceptions\PaymentException;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class CreatePaymentData extends Data
{
    public function __construct(
        #[WithCast(EnumCast::class)]
        public Type $payment_type,
        public VirtualAccountObjectData|OverTheCounterObjectData|QRCodeObjectData|EWalletObjectData|null $payment_property
    ) {}

    public static function fromRequest(CreatePaymentRequest $request): self
    {
        $property = match ($request->payment_type) {
            Type::VIRTUAL_ACCOUNT->value => new VirtualAccountObjectData(
                channel_code: VirtualAccountChannelCode::fromValue($request->channel_code)
            ),
            Type::OVER_THE_COUNTER->value => new OverTheCounterObjectData(
                channel_code: OverTheCounterChannelCode::fromValue($request->channel_code)
            ),
            Type::QR_CODE->value => new QRCodeObjectData(
                channel_code: QRCodeChannelCode::fromValue($request->channel_code)
            ),
            Type::EWALLET->value => new EWalletObjectData(
                channel_code: EWalletChannelCode::fromValue($request->channel_code),
                phone_number: $request->phone_number
            ),
            default => throw PaymentException::invalidPaymentType(),
        };

        return new self(
            payment_type: Type::fromValue($request->payment_type),
            payment_property: $property,
        );
    }
}
