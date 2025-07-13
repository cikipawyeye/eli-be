<?php

declare(strict_types=1);

namespace App\Domains\Notification\Repositories;

use App\Support\Repositories\Repository;

class ReminderNotificationRepository extends Repository
{
    /** @var array<string>|null */
    protected ?array $searchableColumns = ['title', 'message'];

    /** @var array<string>|null */
    protected ?array $sortableColumns = ['title'];

    protected string $defaultSortDirection = self::SORT_DIRECTION_ASC;

    protected string $model = \App\Domains\Notification\Models\ReminderNotification::class;

    public function isActive(?string $status): self
    {
        if ('true' === $status) {
            $this->query->where('is_active', true);
        } elseif ('false' === $status) {
            $this->query->where('is_active', false);
        }

        return $this;
    }
}
