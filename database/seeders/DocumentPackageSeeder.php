<?php

namespace Database\Seeders;

use App\Models\DocumentPackage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentPackageSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $user = User::find(1);

        if (! $user) {
            return;
        }

        DocumentPackage::factory()->completed()->create([
            'user_id' => $user->id,
            'data'    => [
                'contract' => [
                    'number' => '001',
                    'date'   => now()->subDays(5)->format('Y-m-d'),
                    'city'   => 'Москва',
                ],
                'contractor' => [
                    'name'  => $user->name,
                    'email' => $user->email,
                    'phone' => '+7 (999) 123-45-67',
                ],
                'client' => [
                    'name'  => 'ООО «Вектор»',
                    'email' => 'info@vektor.ru',
                ],
                'service' => [
                    'name'        => 'Разработка веб-приложения',
                    'description' => 'Полный цикл: дизайн, вёрстка, backend API, деплой.',
                    'start_date'  => now()->subDays(5)->format('Y-m-d'),
                    'end_date'    => now()->addDays(25)->format('Y-m-d'),
                ],
                'payment' => [
                    'price'    => '45000',
                    'currency' => 'RUB',
                    'terms'    => '5 рабочих дней после подписания акта',
                    'details'  => 'Банковский перевод',
                    'due_date' => now()->addDays(30)->format('Y-m-d'),
                ],
                'meta' => [
                    'act_number'      => 'A-001',
                    'invoice_number'  => 'INV-001',
                    'acceptance_days' => 5,
                    'penalty_terms'   => '0.1% за каждый день просрочки',
                ],
            ],
        ]);

        DocumentPackage::factory()->draft()->create([
            'user_id' => $user->id,
            'data'    => [
                'contract' => [
                    'number' => '002',
                    'date'   => now()->format('Y-m-d'),
                    'city'   => 'Санкт-Петербург',
                ],
                'contractor' => [
                    'name'  => $user->name,
                    'email' => $user->email,
                    'phone' => '+7 (999) 123-45-67',
                ],
                'client' => [
                    'name'  => 'ИП Смирнов А.В.',
                    'email' => 'smirnov@mail.ru',
                ],
                'service' => [
                    'name'        => 'Дизайн лендинга',
                    'description' => 'Лендинг SmartHome — макет в Figma + вёрстка.',
                    'start_date'  => now()->format('Y-m-d'),
                    'end_date'    => now()->addDays(14)->format('Y-m-d'),
                ],
                'payment' => [
                    'price'    => '25000',
                    'currency' => 'RUB',
                    'terms'    => 'Предоплата 50%, остаток после сдачи',
                    'details'  => 'Банковский перевод',
                    'due_date' => now()->addDays(20)->format('Y-m-d'),
                ],
                'meta' => [
                    'act_number'      => 'A-002',
                    'invoice_number'  => 'INV-002',
                    'acceptance_days' => 3,
                    'penalty_terms'   => '0.1% за каждый день просрочки',
                ],
            ],
        ]);
    }
}
