<?php

declare(strict_types=1);

use App\Enums\MemberStatus;
use App\Models\Member;
use App\Models\User;

it('may delete a member', function () {
    // Arrange...
    $user = User::factory()->create();

    // Create a member to delete
    $member = Member::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'contact_number' => '1234567890',
        'email' => 'test@example.com',
        'date_joined' => now(),
        'status' => MemberStatus::Active->value,
    ])->fresh();

    // Act...
    $response = $this
        ->actingAs($user)
        ->from(route('members.index'))
        ->delete(route('members.destroy', $member), [
            'id' => $member->id,
        ]);

    // Assert...
    $response->assertRedirectToRoute('members.index')
        ->assertSessionHasNoErrors();

    expect($member->fresh())->toBeNull(); // The member should be deleted
});
