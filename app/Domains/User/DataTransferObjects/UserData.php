<?php

namespace App\Domains\User\DataTransferObjects;

use App\Domains\User\Models\User;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public string|null $email_verified_at,
        public bool $is_premium,
        public string|Carbon|null $created_at,
        public ?string $password = null,
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
        );
    }
}
