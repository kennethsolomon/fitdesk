<?php

declare(strict_types=1);

use App\Enums\Member\MemberStatus;
use App\Enums\Subscription\SubscriptionStatus;
use App\Enums\Subscription\SubscriptionType;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;

it('may update a subscription', function () {
    // Arrange...
    $user = User::factory()->create()->fresh();
    $member = Member::factory()->create([
        'status' => MemberStatus::Active->value,
    ])->fresh();

    $subscription = $member->subscriptions()->create([
        'type' => SubscriptionType::Monthly,
        'start_date' => Carbon::now(),
        'end_date' => Carbon::now()->addMonth(),
        'amount_paid' => 1000,
        'duration' => 1,
        'status' => SubscriptionStatus::Active,
    ]);

    // Act...
    $response = $this
        ->actingAs($user)
        ->from(route('subscriptions.index'))
        ->put(route('members.subscription.update', [$member, $subscription]), [
            'type' => SubscriptionType::Monthly,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addYear(),
            'amount_paid' => 12000,
            'duration' => 12,
            'status' => SubscriptionStatus::Active,
        ]);

    // Assert...
    $response->assertRedirectToRoute('subscriptions.index')
        ->assertSessionHasNoErrors();

    $updatedSubscription = $subscription->fresh();

    expect($updatedSubscription->type)->toBe(SubscriptionType::Monthly)
        ->and($updatedSubscription->start_date)->toEqual(Carbon::now())
        ->and($updatedSubscription->end_date)->toEqual(Carbon::now()->addYear())
        ->and($updatedSubscription->amount_paid)->toEqual(12000)
        ->and($updatedSubscription->duration)->toEqual(12)
        ->and($updatedSubscription->status)->toBe(SubscriptionStatus::Active);
});
