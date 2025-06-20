<?php

declare(strict_types=1);

namespace App\Domains\Notification\Repositories;

use App\Support\Repositories\Criteria;

class ReminderNotificationCriteria extends Criteria
{
    public function __construct(
        public readonly ?int $limit,
        public readonly ?string $search,
        public readonly ?string $is_active,
    ) {}
}
