<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Subscription\SubscriptionStatus;
use App\Enums\Subscription\SubscriptionType;
use Database\Factories\SubscriptionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @property SubscriptionStatus $status */
/** @property SubscriptionType $type */
final class Subscription extends Model
{
    /** @use HasFactory<SubscriptionFactory> */
    use HasFactory;

    /**
     * The member that owns the subscription.
     *
     * @return BelongsTo<Member, $this>
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'status' => SubscriptionStatus::class,
            'type' => SubscriptionType::class,
        ];
    }
}
