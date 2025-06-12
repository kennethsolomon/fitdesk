<?php

declare(strict_types=1);

use App\Enums\Member\MemberStatus;
use App\Enums\Subscription\SubscriptionStatus;
use App\Enums\Subscription\SubscriptionType;
use App\Models\Member;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;

it('may subscribe an active member monthly', function () {
    // Arrange...
    $user = User::factory()->create()->fresh();
    $member = Member::factory()->create([
        'status' => MemberStatus::Active->value,
    ])->fresh();

    $startDate = Carbon::now()->startOfSecond();
    $endDate = $startDate->copy()->addMonth();

    // Act...
    $response = $this
        ->actingAs($user)
        ->from(route('subscriptions.index'))
        ->post(route('members.subscription.store', $member), [
            'type' => SubscriptionType::Monthly->value,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'amount_paid' => 1000,
            'duration' => 1,
            'status' => SubscriptionStatus::Active->value,

            'member_id' => $member->id,
        ]);

    // Assert...
    $response->assertRedirectToRoute('subscriptions.index')
        ->assertSessionHasNoErrors();

    $subscription = Subscription::where('member_id', $member->id)->first();

    expect($subscription->count())->toBe(1)
        ->and($subscription)->toBeInstanceOf(Subscription::class)
        ->and($subscription->member_id)->toEqual($member->id)
        ->and($subscription->type)->toBe(SubscriptionType::Monthly)
        ->and($subscription->start_date)->toEqual($startDate)
        ->and($subscription->end_date)->toEqual($endDate)
        ->and($subscription->amount_paid)->toEqual(1000)
        ->and($subscription->duration)->toEqual(1)
        ->and($subscription->status)->toBe(SubscriptionStatus::Active);
});

it('redirects to subscriptions index when member is not active', function () {
    // Arrange...
    $user = User::factory()->create()->fresh();
    $member = Member::factory()->create([
        'status' => MemberStatus::Inactive->value,
    ])->fresh();

    // Act...
    $response = $this
        ->actingAs($user)
        ->from(route('subscriptions.index'))
        ->post(route('members.subscription.store', $member), [
            'type' => SubscriptionType::Monthly->value,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonth(),
            'amount_paid' => 1000,
            'duration' => 1,
            'status' => SubscriptionStatus::Active->value,

            'member_id' => $member->id,
        ]);

    // Assert...
    $response->assertRedirectToRoute('subscriptions.index')
        ->assertSessionHasErrors([
            'member' => 'Only active members can be subscribed.',
        ]);
});

it('redirects to subscriptions index when member has an active subscription', function () {
    // Arrange...
    $user = User::factory()->create()->fresh();
    $member = Member::factory()->create([
        'status' => MemberStatus::Active->value,
    ])->fresh();

    Subscription::factory()->create([
        'member_id' => $member->id,
        'status' => SubscriptionStatus::Active->value,
    ]);

    // Act...
    $response = $this
        ->actingAs($user)
        ->from(route('subscriptions.index'))
        ->post(route('members.subscription.store', $member), [
            'type' => SubscriptionType::Monthly->value,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonth(),
            'amount_paid' => 1000,
            'duration' => 1,
            'status' => SubscriptionStatus::Active->value,

            'member_id' => $member->id,
        ]);

    // Assert...
    $response->assertRedirectToRoute('subscriptions.index')
        ->assertSessionHasErrors([
            'member' => 'This member already has an active subscription.',
        ]);
});
