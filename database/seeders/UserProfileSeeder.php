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
        $profiles = [
            [
                'email' => 'test@example.com',
                'full_name' => 'Test User',
                'employment_type' => EmploymentType::Freelancer,
                'default_currency' => 'USD',
            ],
            [
                'email' => 'trial@example.com',
                'full_name' => 'Trial User',
                'company_name' => 'Trial Corp',
                'job_title' => 'Developer',
                'employment_type' => EmploymentType::Employee,
                'default_currency' => 'EUR',
            ],
            [
                'email' => 'paid@example.com',
                'full_name' => 'Paid User',
                'company_name' => 'Paid LLC',
                'job_title' => 'CEO',
                'address' => '123 Business St, New York, NY',
                'tax_id' => '1234567890',
                'phone' => '+1 555 000 1234',
                'employment_type' => EmploymentType::Company,
                'default_currency' => 'USD',
            ],
        ];

        foreach ($profiles as $data) {
            $email = $data['email'];
            unset($data['email']);

            $user = User::where('email', $email)->first();
            if ($user) {
                UserProfile::updateOrCreate(['user_id' => $user->id], $data);
            }
        }
    }
}
