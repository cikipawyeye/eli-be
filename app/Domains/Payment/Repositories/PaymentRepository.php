<?php

declare(strict_types=1);

namespace App\Domains\Payment\Repositories;

use App\Support\Repositories\Repository;

class PaymentRepository extends Repository
{
    protected string $model = \App\Domains\Payment\Models\Payment::class;

    /** @var array<string>|null */
    protected ?array $searchableColumns = ['user.name'];

    protected ?array $with = ['user.name'];

    public function userId(?int $id): self
    {
        if ($id) {
            $this->query->where('user_id', $id);
        }

        return $this;
    }
}
