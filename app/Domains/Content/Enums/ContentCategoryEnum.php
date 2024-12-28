<?php

declare(strict_types=1);

namespace App\Domains\Content\Enums;

use App\Support\Traits\EnumTrait;

enum ContentCategoryEnum: int
{
    use EnumTrait;

    case Motivation = 0;
    case Reminder = 1;

    public function translated(): string
    {
        return match ($this->value) {
            self::Motivation->value => __('app.motivation'),
            self::Reminder->value => __('app.reminder'),
        };
    }
}
