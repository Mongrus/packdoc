<?php

namespace Database\Factories;

use App\Enums\DocumentPackageStatus;
use App\Models\DocumentPackage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DocumentPackage>
 */
class DocumentPackageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type'    => 'freelance',
            'status'  => fake()->randomElement(DocumentPackageStatus::cases()),
            'data'    => [
                'contractor_name'     => fake()->name(),
                'contractor_email'    => fake()->safeEmail(),
                'contractor_phone'    => fake()->phoneNumber(),
                'client_name'         => fake()->randomElement(['ООО', 'ИП', 'АО']) . ' «' . fake()->company() . '»',
                'client_email'        => fake()->companyEmail(),
                'service'             => fake()->randomElement(['Разработка сайта', 'Дизайн логотипа', 'SEO-аудит', 'Копирайтинг']),
                'service_description' => fake()->sentence(),
                'price'               => fake()->numberBetween(5, 200) * 1000 . ' ₽',
                'date'                => fake()->date('Y-m-d'),
            ],
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => DocumentPackageStatus::Draft,
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn () => [
            'status' => DocumentPackageStatus::Completed,
        ]);
    }
}
