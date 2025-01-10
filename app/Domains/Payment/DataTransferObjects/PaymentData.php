<?php

namespace App\Domains\Payment\DataTransferObjects;

use App\Domains\Payment\Enums\PaymentMethodType;
use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\States\Payment\PaymentState;
use App\Domains\User\DataTransferObjects\UserData;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class PaymentData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $user_id,
        public readonly ?string $x_payment_id,
        public readonly ?string $x_payment_request_id,
        public readonly ?string $x_payment_method_id,
        public readonly int $amount,
        #[WithCast(EnumCast::class)]
        public readonly PaymentMethodType $payment_method_type,
        public readonly string|PaymentState $state,
        public readonly string|Carbon|null $created_at,
        public readonly Lazy|UserData|null $user,
    ) {}

    public static function fromModel(Payment $payment): self
    {
        return new self(
            id: $payment->id,
            user_id: $payment->user_id,
            x_payment_id: $payment->x_payment_id,
            x_payment_request_id: $payment->x_payment_request_id,
            x_payment_method_id: $payment->x_payment_method_id,
            amount: $payment->amount,
            payment_method_type: PaymentMethodType::from($payment->payment_method_type),
            state: $payment->state,
            created_at: $payment->created_at,
            user: Lazy::create(fn() => $payment->user ? UserData::fromModel($payment->user) : null),
        );
    }
}
