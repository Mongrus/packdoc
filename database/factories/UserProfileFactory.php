<?php

namespace Database\Factories;

use App\Enums\EmploymentType;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserProfile>
 */
class UserProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'full_name' => fake()->name(),
            'company_name' => fake()->optional(0.4)->company(),
            'job_title' => fake()->optional(0.6)->jobTitle(),
            'address' => fake()->optional(0.7)->address(),
            'tax_id' => fake()->optional(0.4)->numerify('##########'),
            'phone' => fake()->optional(0.8)->phoneNumber(),
            'employment_type' => fake()->randomElement(EmploymentType::cases()),
            'default_currency' => fake()->randomElement(['USD', 'EUR', 'RUB', 'GBP']),
        ];
    }
}
