<?php

namespace Database\Seeders;

use App\Models\DocumentCategory;
use App\Models\DocumentPackage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentPackageSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $user = User::first();
        $freelance = DocumentCategory::where('name', 'Фриланс')->first();

        if (! $user || ! $freelance) {
            return;
        }

        DocumentPackage::factory()->completed()->create([
            'user_id'     => $user->id,
            'name'        => 'Проект для Вектор',
            'category_id' => $freelance->id,
            'file_path'   => null,
            'data'        => [
                'fio'         => $user->name,
                'client_name' => 'ООО «Вектор»',
                'price'       => 45000,
                'date'        => now()->subDays(5)->format('d.m.Y'),
                'description' => 'Разработка веб-приложения',
            ],
        ]);

        DocumentPackage::factory()->draft()->create([
            'user_id'     => $user->id,
            'name'        => 'Лендинг SmartHome',
            'category_id' => $freelance->id,
            'data'        => [
                'fio'         => $user->name,
                'client_name' => 'ИП Смирнов А.В.',
                'price'       => 25000,
                'date'        => now()->format('d.m.Y'),
                'description' => 'Дизайн лендинга',
            ],
        ]);
    }
}
