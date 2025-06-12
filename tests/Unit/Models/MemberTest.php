<?php

declare(strict_types=1);

use App\Enums\Member\MemberStatus;
use App\Models\Member;
use Illuminate\Support\Collection;

test('to array', function () {
    $member = Member::factory()->create()->fresh();

    // Make sure the toArray method returns the expected keys in order
    expect(array_keys($member->toArray()))
        ->toBe([
            'id',
            'first_name',
            'last_name',
            'contact_number',
            'email',
            'date_joined',
            'status',
            'created_at',
            'updated_at',
        ]);
});

test('casts', function () {
    $member = Member::factory()->create()->fresh();

    // Check if the casts method returns the expected keys
    expect(array_keys($member->getCasts()))
        ->toBe([
            'id',
            'status',
        ]);

    // Check if the status is cast to MemberStatus enum
    expect($member->status)->toBeInstanceOf(MemberStatus::class);
});

test('subscriptions relation', function () {
    $member = Member::factory()->create()->fresh();

    // Check if the subscriptions relation exists
    expect($member->subscriptions)->toBeInstanceOf(Collection::class);

    // Check if the subscriptions relation is empty initially
    expect($member->subscriptions->isEmpty())->toBeTrue();
});
