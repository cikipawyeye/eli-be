<?php

declare(strict_types=1);

namespace App\Domains\Content\Enums;

use App\Support\Traits\EnumTrait;

enum ContentTypeEnum: string
{
    use EnumTrait;

    case Premium = 'premium_content';
    case NonPremium = 'non_premium_content';

    public function translated(): string
    {
        return match ($this->value) {
            self::Premium->value => __('app.premium_content'),
            self::NonPremium->value => __('app.non_premium_content'),
        };
    }
}
