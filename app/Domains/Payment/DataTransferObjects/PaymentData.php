<?php

namespace App\Domains\Payment\DataTransferObjects;

use App\Domains\Payment\Enums\PaymentMethodType;
use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\States\Payment\PaymentState;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

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
        public readonly ?PaymentMethodType $payment_method_type,
        #[WithCast(EnumCast::class)]
        public readonly PaymentState $state,
        public readonly string|Carbon|null $created_at,
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
            payment_method_type: $payment->payment_method_type,
            state: $payment->state,
            created_at: $payment->created_at,
        );
    }
}
