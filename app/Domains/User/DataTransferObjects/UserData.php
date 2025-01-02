<?php

namespace App\Domains\User\DataTransferObjects;

use App\Domains\Payment\DataTransferObjects\PaymentData;
use App\Domains\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class UserData extends Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $email,
        public ?string $email_verified_at,
        public ?bool $is_premium,
        public string|Carbon|null $created_at,
        public ?string $password,
        public Lazy|Collection|null $payments,
    ) {}

    public static function fromModel(User $user): self
    {
        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            email_verified_at: $user->email_verified_at,
            is_premium: $user->is_premium,
            created_at: $user->created_at,
            password: $user->password,
            payments: self::getPayments($user),
        );
    }

    protected static function getPayments(User $user): Lazy
    {
        return Lazy::create(fn() => PaymentData::collect($user->payments, Collection::class));
    }
}
