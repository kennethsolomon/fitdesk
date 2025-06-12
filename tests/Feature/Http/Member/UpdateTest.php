<?php

declare(strict_types=1);

use App\Enums\Member\MemberStatus;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;

it('may update a member', function () {
    // Arrange...
    $user = User::factory()->create();

    // Create a member to update
    $member = Member::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'contact_number' => '1234567890',
        'email' => 'test@example.com',
        'date_joined' => now(),
        'status' => MemberStatus::Active->value,
    ]);

    // Act...
    $response = $this
        ->actingAs($user)
        ->from(route('members.index'))
        ->post(route('members.update', $member), [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'contact_number' => '0987654321',
            'email' => 'testedit@example.com',
            'date_joined' => now(),
            'status' => MemberStatus::Inactive->value,
        ]);

    // Assert...
    $response->assertRedirectToRoute('members.index')
        ->assertSessionHasNoErrors();

    $updatedMember = Member::find($member->id);
    expect($updatedMember)->toBeInstanceOf(Member::class)
        ->and($updatedMember->first_name)->toBe('Jane')
        ->and($updatedMember->last_name)->toBe('Smith')
        ->and($updatedMember->contact_number)->toBe('0987654321')
        ->and($updatedMember->email)->toBe('testedit@example.com')
        ->and(Carbon::parse($updatedMember->date_joined))->equalTo(now())
        ->and($updatedMember->status)->toBe(MemberStatus::Inactive);
});
