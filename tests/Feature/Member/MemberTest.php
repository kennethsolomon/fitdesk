<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Member;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('authenticated users can visit the member', function () {
    $user = \App\Models\User::factory()->create();

    actingAs($user);

    $response = get(route('member.index'));

    $response->assertStatus(200);

    $response->assertInertia(fn (Assert $page) =>
        $page->component('Member/Index')
    );
});

test('unauthenticated users cannot visit the member', function () {
    $response = get(route('member.index'));

    $response->assertRedirectToRoute('login');
});

test('authenticated users can create a member', function () {
    $user = User::factory()->create();

    actingAs($user);

    $response = post('/member/create', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'contact_number' => '1234567890',
        'email' => '4yDd3@example.com',
        'date_joined' => '2023-01-01',
        'status' => 'active', // active and inactive
    ]);

    assertDatabaseHas('members', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'contact_number' => '1234567890',
        'email' => '4yDd3@example.com',
        'date_joined' => '2023-01-01',
        'status' => 'active', // active and inactive
    ]);

    $response->assertStatus(200);

    $response->assertRedirectToRoute('member.index');
});

test('unauthenticated users cannot create a member', function () {
    $response = post(route('member.store'), [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'contact_number' => '1234567890',
        'email' => '4yDd3@example.com',
        'date_joined' => '2023-01-01',
        'status' => 'active', // active and inactive
    ]);
    $response->assertStatus(302);

    $response->assertRedirectToRoute('login');
});

test('authenticated users can update a member', function () {
    $user = User::factory()->create();

    actingAs($user);

    $member = Member::factory()->create(
        [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'contact_number' => '1234567890',
            'email' => '4yDd3@example.com',
            'date_joined' => '2023-01-01',
            'status' => 'active', // active and inactive
        ]
    );

    $response = post("/member/{$member->id}/update", [
        'first_name' => 'John',
        'last_name' => 'Cena',
        'contact_number' => '1234567890',
        'email' => '4yDd3@example.com',
        'date_joined' => '2023-01-01',
        'status' => 'inactive', // active and inactive
    ]);

    assertDatabaseHas('members', [
        'first_name' => 'John',
        'last_name' => 'Cena',
        'contact_number' => '1234567890',
        'email' => '4yDd3@example.com',
        'date_joined' => '2023-01-01',
        'status' => 'inactive', // active and inactive
    ]);

    $response->assertStatus(200);

    $response->assertRedirectToRoute('member.index');
});

test('unauthenticated users can update a member', function () {
    $member = Member::factory()->create(
        [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'contact_number' => '1234567890',
            'email' => '4yDd3@example.com',
            'date_joined' => '2023-01-01',
            'status' => 'active', // active and inactive
        ]
    );

    $response = post("/member/{$member->id}/update", [
        'first_name' => 'John',
        'last_name' => 'Cena',
        'contact_number' => '1234567890',
        'email' => '4yDd3@example.com',
        'date_joined' => '2023-01-01',
        'status' => 'inactive', // active and inactive
    ]);

    $response->assertStatus(302);
    $response->assertRedirectToRoute('login');
});

test('authenticated users can delete a member', function() {
    $user = User::factory()->create();

    actingAs($user);

     $member = Member::factory()->create(
        [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'contact_number' => '1234567890',
            'email' => '4yDd3@example.com',
            'date_joined' => '2023-01-01',
            'status' => 'active', // active and inactive
        ]
    );

    $response = delete("/member/{$member->id}/delete");

    assertDatabaseMissing('members', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'contact_number' => '1234567890',
        'email' => '4yDd3@example.com',
        'date_joined' => '2023-01-01',
        'status' => 'active', // active and inactive
    ]);

    $response->assertStatus(200);
});

test('unauthenticated users cannot delete a member', function() {
    $member = Member::factory()->create(
        [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'contact_number' => '1234567890',
            'email' => '4yDd3@example.com',
            'date_joined' => '2023-01-01',
            'status' => 'active', // active and inactive
        ]
    );

    $response = delete("/member/{$member->id}/delete");

    $response->assertStatus(302);
    $response->assertRedirectToRoute('login');
});
