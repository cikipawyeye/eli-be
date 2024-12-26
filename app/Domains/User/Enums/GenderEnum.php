<?php

declare(strict_types=1);

namespace App\Domains\User\Enums;

use App\Support\Traits\EnumTrait;

enum GenderEnum: string
{
    use EnumTrait;

    case Male = 'M';
    case Female = 'F';
}
