<?php

declare(strict_types=1);

namespace App\Enums\Subscription;

enum SubscriptionType: string
{
    case Daily = 'daily';
    case Monthly = 'monthly';
}
