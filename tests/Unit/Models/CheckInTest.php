<?php

declare(strict_types=1);

use App\Models\CheckIn;

test('to array', function () {
    $checkIn = CheckIn::factory()->create()->fresh();

    // Make sure the toArray method returns the expected keys in order
    expect(array_keys($checkIn->toArray()))
        ->toBe([
            'id',
            'member_id',
            'check_in_time',
            'check_out_time',
            'amount_paid',
            'created_at',
            'updated_at',
        ]);
});
