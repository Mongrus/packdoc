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
                'contractor_name'     => $user->name,
                'contractor_email'    => $user->email,
                'contractor_phone'    => '+7 (999) 123-45-67',
                'client_name'         => 'ООО «Вектор»',
                'client_email'        => 'info@vektor.ru',
                'service'             => 'Разработка веб-приложения',
                'service_description' => 'Полный цикл: дизайн, вёрстка, backend API, деплой.',
                'price'               => '45 000 ₽',
                'date'                => now()->subDays(5)->format('Y-m-d'),
            ],
        ]);

        DocumentPackage::factory()->draft()->create([
            'user_id' => $user->id,
            'data'    => [
                'contractor_name'     => $user->name,
                'contractor_email'    => $user->email,
                'contractor_phone'    => '+7 (999) 123-45-67',
                'client_name'         => 'ИП Смирнов А.В.',
                'client_email'        => 'smirnov@mail.ru',
                'service'             => 'Дизайн лендинга',
                'service_description' => 'Лендинг SmartHome — макет в Figma + вёрстка.',
                'price'               => '25 000 ₽',
                'date'                => now()->format('Y-m-d'),
            ],
        ]);
    }
}
