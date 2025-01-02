<?php

declare(strict_types=1);

namespace App\Domains\Payment\Repositories;

use App\Support\Repositories\Criteria;

class PaymentCriteria extends Criteria
{
    public function __construct(
        public readonly ?int $limit,
        public readonly ?string $search,
        public readonly ?int $user_id,
    ) {}
}
