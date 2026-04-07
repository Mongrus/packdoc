<?php

namespace Database\Factories;

use App\Enums\DocumentPackageStatus;
use App\Models\DocumentPackage;
use App\Models\DocumentTemplate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DocumentPackage>
 */
class DocumentPackageFactory extends Factory
{
    public function definition(): array
    {
        $status = fake()->randomElement(DocumentPackageStatus::cases());

        return [
            'user_id' => User::factory(),
            'template_id' => DocumentTemplate::factory(),
            'status' => $status,
            'data' => [
                'fio' => fake()->name(),
                'client_name' => fake()->company(),
                'price' => fake()->numberBetween(1000, 100000),
                'date' => fake()->date('d.m.Y'),
                'description' => fake()->sentence(),
            ],
            'file_path' => $status === DocumentPackageStatus::Completed
                ? 'packages/' . fake()->uuid() . '.pdf'
                : null,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => DocumentPackageStatus::Draft,
            'file_path' => null,
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn () => [
            'status' => DocumentPackageStatus::Completed,
            'file_path' => 'packages/' . fake()->uuid() . '.pdf',
        ]);
    }
}
