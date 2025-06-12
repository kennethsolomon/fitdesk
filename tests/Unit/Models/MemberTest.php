<?php

declare(strict_types=1);

use App\Models\Member;

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
