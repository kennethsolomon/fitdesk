<?php

declare(strict_types=1);

namespace App\Enums\Subscription;

enum SubscriptionStatus: string
{
    case Active = 'active';
    case Expired = 'expired';
}
