<?php

declare(strict_types=1);

use App\Enums\Subscription\SubscriptionStatus;
use App\Enums\Subscription\SubscriptionType;
use App\Models\Member;
use App\Models\Subscription;

test('to array', function () {
    $subscription = Subscription::factory()->create()->fresh();

    // Make sure the toArray method returns the expected keys in order
    expect(array_keys($subscription->toArray()))
        ->toBe([
            'id',
            'member_id',
            'type',
            'start_date',
            'end_date',
            'amount_paid',
            'duration',
            'status',
            'created_at',
            'updated_at',
        ]);
});

test('casts', function () {
    $subscription = Subscription::factory()->create()->fresh();

    // Check if the casts method returns the expected keys
    expect(array_keys($subscription->getCasts()))
        ->toBe([
            'id',
            'start_date',
            'end_date',
            'status',
            'type',
        ]);

    // Check if the status is cast to SubscripotionType and SubscriptionStatus enum
    expect($subscription->status)->toBeInstanceOf(SubscriptionStatus::class)
        ->and($subscription->type)->toBeInstanceOf(SubscriptionType::class);
});

test('member relation', function () {
    $subscripotion = Subscription::factory()->create()->fresh();

    // Check if the subscriptions relation exists
    expect($subscripotion->member)->toBeInstanceOf(Member::class);

    // Check if the subscriptions relation has member
    expect($subscripotion->member->id)->toEqual($subscripotion->member_id);
});
