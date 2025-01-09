<?php

declare(strict_types=1);

namespace App\Domains\User\Enums;

use App\Support\Traits\EnumTrait;

enum GenderEnum: string
{
    use EnumTrait;

    case Male = 'M';
    case Female = 'F';

    public function translated(): string
    {
        return match ($this->value) {
            self::Male->value => __('app.male'),
            self::Female->value => __('app.female'),
            default => $this->name,
        };
    }
}
