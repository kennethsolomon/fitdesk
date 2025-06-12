<?php

declare(strict_types=1);

use App\Models\Subscription;
use App\Models\User;

it('lists the subscriptions', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $subscriptions = Subscription::factory()->count(3)->create();

    $response = $this
        ->actingAs($user)
        ->get(route('subscriptions.index'));

    $response->assertStatus(200);

    $response->assertJson($subscriptions->toArray());
});
