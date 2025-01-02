<?php

declare(strict_types=1);

namespace App\Domains\User\Repositories;

use App\Domains\User\Enums\RoleEnum;
use App\Support\Repositories\Repository;

class UserRepository extends Repository
{
    /** @var array<string>|null */
    protected ?array $searchableColumns = ['name', 'email'];

    /** @var array<string>|null */
    protected ?array $sortableColumns = ['name'];

    protected string $defaultSortDirection = self::SORT_DIRECTION_ASC;

    protected string $model = \App\Domains\User\Models\User::class;

    public function role(?string $role): self
    {
        if (in_array($role, RoleEnum::toArray())) {
            $this->query->whereHas('roles', function ($builder) use ($role) {
                $builder->where('name', $role);
            });
        }

        return $this;
    }

    public function isPremium(?string $status): self
    {
        if ($status == 'true') {
            $this->query->where('is_premium', true);
        } elseif ($status == 'false') {
            $this->query->where('is_premium', false);
        }

        return $this;
    }
}
