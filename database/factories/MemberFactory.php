<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\MemberStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
final class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $memberStatuses = MemberStatus::cases();

        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'contact_number' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'date_joined' => fake()->date(),
            'status' => fake()->randomElement($memberStatuses),
        ];
    }
}
