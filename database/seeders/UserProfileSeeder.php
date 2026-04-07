<?php

namespace Database\Seeders;

use App\Enums\EmploymentType;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $user = User::where('email', 'admin@gmail.com')->first();

        if ($user) {
            UserProfile::updateOrCreate(['user_id' => $user->id], [
                'full_name'        => 'Admin',
                'company_name'     => 'Packdock LLC',
                'job_title'        => 'CEO',
                'address'          => 'Москва, ул. Примерная, д. 1',
                'tax_id'           => '7701234567',
                'phone'            => '+7 999 123-45-67',
                'employment_type'  => EmploymentType::Company,
                'default_currency' => 'RUB',
            ]);
        }
    }
}
