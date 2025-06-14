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
        'type' => SubscriptionType::Monthly->value,
        'start_date' => Carbon::now(),
        'end_date' => Carbon::now()->addMonth(),
        'amount_paid' => 1000,
        'duration' => 1,
        'status' => SubscriptionStatus::Active->value,
    ]);

    // Act...

    // Updated Dates
    $startDate = Carbon::now()->startOfSecond();
    $endDate = $startDate->copy()->addMonth();

    $response = $this
        ->actingAs($user)
        ->from(route('subscriptions.index'))
        ->post(route('members.subscription.update', [$subscription, $member]), [
            'type' => SubscriptionType::Monthly->value,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'amount_paid' => 12000,
            'duration' => 12,
            'status' => SubscriptionStatus::Active->value,
        ]);

    // Assert...
    $response->assertRedirectToRoute('subscriptions.index')
        ->assertSessionHasNoErrors();

    $updatedSubscription = $subscription->fresh();

    expect($updatedSubscription->type)->toBe(SubscriptionType::Monthly)
        ->and($updatedSubscription->start_date)->toEqual($startDate)
        ->and($updatedSubscription->end_date)->toEqual($endDate)
        ->and($updatedSubscription->amount_paid)->toEqual(12000)
        ->and($updatedSubscription->duration)->toEqual(12)
        ->and($updatedSubscription->status)->toBe(SubscriptionStatus::Active);
});

it('may deactivate a subscription', function () {
    // Arrange...
    $user = User::factory()->create()->fresh();
    $member = Member::factory()->create([
        'status' => MemberStatus::Active->value,
    ])->fresh();

    $subscription = $member->subscriptions()->create([
        'type' => SubscriptionType::Monthly->value,
        'start_date' => Carbon::now(),
        'end_date' => Carbon::now()->addMonth(),
        'amount_paid' => 1000,
        'duration' => 1,
        'status' => SubscriptionStatus::Active->value,
    ]);

    // Act...

    // Updated Dates
    $startDate = Carbon::now()->startOfSecond();
    $endDate = $startDate->copy()->addMonth();

    $response = $this
        ->actingAs($user)
        ->from(route('subscriptions.index'))
        ->post(route('members.subscription.update', [$subscription, $member]), [
            'type' => SubscriptionType::Monthly->value,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'amount_paid' => 12000,
            'duration' => 12,
            'status' => SubscriptionStatus::Expired->value,
        ]);

    // Assert...
    $response->assertRedirectToRoute('subscriptions.index')
        ->assertSessionHasNoErrors();

    $updatedSubscription = $subscription->fresh();

    expect($updatedSubscription->type)->toBe(SubscriptionType::Monthly)
        ->and($updatedSubscription->start_date)->toEqual($startDate)
        ->and($updatedSubscription->end_date)->toEqual($endDate)
        ->and($updatedSubscription->amount_paid)->toEqual(12000)
        ->and($updatedSubscription->duration)->toEqual(12)
        ->and($updatedSubscription->status)->toBe(SubscriptionStatus::Expired);
});

it('redirects to subscriptions index when member is not active', function () {
    // Arrange...
    $user = User::factory()->create()->fresh();
    $member = Member::factory()->create([
        'status' => MemberStatus::Inactive->value,
    ])->fresh();

    $subscription = $member->subscriptions()->create([
        'type' => SubscriptionType::Monthly->value,
        'start_date' => Carbon::now(),
        'end_date' => Carbon::now()->addMonth(),
        'amount_paid' => 1000,
        'duration' => 1,
        'status' => SubscriptionStatus::Active->value,
    ]);

    // Act...

    // Updated Dates
    $startDate = Carbon::now()->startOfSecond();
    $endDate = $startDate->copy()->addMonth();

    $response = $this
        ->actingAs($user)
        ->from(route('subscriptions.index'))
        ->post(route('members.subscription.update', [$subscription, $member]), [
            'type' => SubscriptionType::Monthly->value,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'amount_paid' => 12000,
            'duration' => 12,
            'status' => SubscriptionStatus::Active->value,
        ]);

    // Assert...
    $response->assertRedirectToRoute('subscriptions.index')
        ->assertSessionHasErrors([
            'member' => 'Only active members can be subscribed.',
        ]);
});
