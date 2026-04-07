<?php

namespace Database\Seeders;

use App\Enums\SubscriptionStatus;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name'                  => 'Admin',
            'email'                 => 'admin@gmail.com',
            'password'              => bcrypt('111aaa222bbb'),
            'subscription_status'   => SubscriptionStatus::Paid,
            'package_created_count' => 2,
        ]);

        $this->call(UserProfileSeeder::class);
        $this->call(DocumentCategorySeeder::class);
        $this->call(DocumentTemplateSeeder::class);
        $this->call(DocumentPackageSeeder::class);
    }
}
