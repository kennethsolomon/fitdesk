<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Member\MemberStatus;
use Database\Factories\MemberFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** @property MemberStatus $status */
final class Member extends Model
{
    /** @use HasFactory<MemberFactory> */
    use HasFactory;

    public function casts(): array
    {
        return [
            'status' => MemberStatus::class,
        ];
    }

    /**
     * Get the members subscriptions.
     *
     * @return HasMany<Subscription, $this>
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
