<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Subscription\SubscriptionStatus;
use App\Enums\Subscription\SubscriptionType;
use App\Models\Member;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        $subscriptionTypes = SubscriptionType::cases();
        $subscriptionStatuses = SubscriptionStatus::cases();

        return [
            'type' => fake()->randomElement($subscriptionTypes),
            'status' => fake()->randomElement($subscriptionStatuses),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'amount_paid' => $this->faker->word(),
            'duration' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'member_id' => Member::factory(),
        ];
    }
}
