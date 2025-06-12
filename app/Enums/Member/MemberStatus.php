<?php

declare(strict_types=1);

namespace App\Enums\Member;

enum MemberStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
}
