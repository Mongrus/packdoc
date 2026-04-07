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
        $startDate = fake()->dateTimeBetween('now', '+30 days');
        $endDate = fake()->dateTimeBetween($startDate, '+90 days');

        return [
            'user_id' => User::factory(),
            'type'    => 'freelance',
            'status'  => fake()->randomElement(DocumentPackageStatus::cases()),
            'data'    => [
                'contract' => [
                    'number' => fake()->numerify('###'),
                    'date'   => fake()->date('Y-m-d'),
                    'city'   => fake()->city(),
                ],
                'contractor' => [
                    'name'  => fake()->name(),
                    'email' => fake()->safeEmail(),
                    'phone' => fake()->phoneNumber(),
                ],
                'client' => [
                    'name'  => fake()->randomElement(['ООО', 'ИП', 'АО']) . ' «' . fake()->company() . '»',
                    'email' => fake()->companyEmail(),
                ],
                'service' => [
                    'name'        => fake()->randomElement(['Разработка сайта', 'Дизайн логотипа', 'SEO-аудит', 'Копирайтинг']),
                    'description' => fake()->sentence(),
                    'start_date'  => $startDate->format('Y-m-d'),
                    'end_date'    => $endDate->format('Y-m-d'),
                ],
                'payment' => [
                    'price'    => (string) (fake()->numberBetween(5, 200) * 1000),
                    'currency' => fake()->randomElement(['RUB', 'USD', 'EUR']),
                    'terms'    => '5 рабочих дней после подписания акта',
                    'details'  => 'Банковский перевод',
                    'due_date' => fake()->dateTimeBetween($endDate, '+120 days')->format('Y-m-d'),
                ],
                'meta' => [
                    'act_number'      => 'A-' . fake()->numerify('###'),
                    'invoice_number'  => 'INV-' . fake()->numerify('###'),
                    'acceptance_days' => fake()->randomElement([3, 5, 7]),
                    'penalty_terms'   => '0.1% за каждый день просрочки',
                ],
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
