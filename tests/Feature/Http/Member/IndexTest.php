<?php

declare(strict_types=1);

use App\Models\Member;
use App\Models\User;

it('lists the members', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $members = Member::factory()->count(3)->create();

    $response = $this
        ->actingAs($user)
        ->get(route('members.index'));

    $response->assertStatus(200);

    $response->assertJson($members->toArray());
});
