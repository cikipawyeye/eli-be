<?php

namespace App\Domains\User\DataTransferObjects;

use App\Domains\Payment\DataTransferObjects\PaymentData;
use App\Domains\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Laravolt\Indonesia\Models\City;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class UserData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $email,
        public readonly ?string $email_verified_at,
        public readonly ?bool $is_premium,
        #[WithCast(DateTimeInterfaceCast::class, timeZone: 'Asia/Jakarta', format: 'Y-m-d')]
        public readonly string|Carbon|null $birth_date,
        public readonly ?string $job,
        public readonly ?string $city_code,
        public readonly string|Carbon|null $created_at,
        public readonly Lazy|string|null $password,
        public readonly Lazy|Collection|null $payments,
        public readonly Lazy|City|null $city,
    ) {}

    public static function fromModel(User $user): self
    {
        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            email_verified_at: $user->email_verified_at,
            is_premium: $user->is_premium ?? false,
            birth_date: $user->birth_date,
            job: $user->job,
            city_code: $user->city_code,
            created_at: $user->created_at,
            password: Lazy::create(fn() => null),
            payments: self::getPayments($user),
            city: self::getCity($user),
        );
    }

    protected static function getPayments(User $user): Lazy
    {
        return Lazy::create(fn() => PaymentData::collect($user->payments, Collection::class));
    }

    protected static function getCity(User $user): Lazy
    {
        return Lazy::create(fn() => $user->city ? CityData::fromModel($user->city) : null);
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        if ($this->birth_date instanceof Carbon) {
            $data['birth_date'] = $this->birth_date->format('Y-m-d');
        }

        return $data;
    }
}
