<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CheckIn;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class CheckInFactory extends Factory
{
    protected $model = CheckIn::class;

    public function definition(): array
    {
        return [
            'check_in_time' => Carbon::now(),
            'check_out_time' => Carbon::now(),
            'amount_paid' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'member_id' => Member::factory(),
        ];
    }
}
