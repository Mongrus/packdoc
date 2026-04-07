<?php

namespace Database\Seeders;

use App\Enums\SubscriptionStatus;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\DocumentCategorySeeder;
use Database\Seeders\UserProfileSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subscription_status' => SubscriptionStatus::Free,
            'package_created_count' => 0,
        ]);

        User::factory()->create([
            'name' => 'Trial User',
            'email' => 'trial@example.com',
            'subscription_status' => SubscriptionStatus::Trial,
            'package_created_count' => 2,
        ]);

        User::factory()->create([
            'name' => 'Paid User',
            'email' => 'paid@example.com',
            'subscription_status' => SubscriptionStatus::Paid,
            'package_created_count' => 10,
        ]);

        $this->call(UserProfileSeeder::class);
        $this->call(DocumentCategorySeeder::class);
        $this->call(DocumentTemplateSeeder::class);
        $this->call(DocumentPackageSeeder::class);
    }
}
