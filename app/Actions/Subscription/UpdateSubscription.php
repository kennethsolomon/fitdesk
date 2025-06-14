<?php

declare(strict_types=1);

namespace App\Actions\Subscription;

use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

final class UpdateSubscription
{
    /**
     * Execute the action.
     *
     * @param  array{type: string, start_date: string, end_date: string, amount_paid: int, duration: int, status: string}  $attributes
     */
    public function handle(array $attributes, Subscription $subscription): Subscription
    {
        return DB::transaction(function () use ($attributes, $subscription) {
            $subscription->update([
                'type' => $attributes['type'],
                'start_date' => $attributes['start_date'],
                'end_date' => $attributes['end_date'],
                'amount_paid' => $attributes['amount_paid'],
                'duration' => $attributes['duration'],
                'status' => $attributes['status'],
            ]);

            return $subscription->refresh(); // ensures the returned model has the latest data
        });
    }
}
