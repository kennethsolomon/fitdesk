<?php

declare(strict_types=1);

use App\Enums\Member\MemberStatus;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;

it('may create a member', function () {
    // Arrange...
    $user = User::factory()->create();

    // Act...
    $response = $this
        ->actingAs($user)
        ->from(route('members.index'))
        ->post(route('members.store'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'contact_number' => '1234567890',
            'email' => 'test@example.com',
            'date_joined' => now(),
            'status' => MemberStatus::Active->value,
        ]);

    // Assert...
    $response->assertRedirectToRoute('members.index')
        ->assertSessionHasNoErrors();

    $todos = Member::all();
    expect($todos)->toHaveCount(1)->and($todos->first())->toBeInstanceOf(Member::class)
        ->and($todos->first()->first_name)->toBe('John')
        ->and($todos->first()->last_name)->toBe('Doe')
        ->and($todos->first()->contact_number)->toBe('1234567890')
        ->and($todos->first()->email)->toBe('test@example.com')
        ->and(Carbon::parse($todos->first()->date_joined))->equalTo(now())
        ->and($todos->first()->status)->toBe(MemberStatus::Active);
});
