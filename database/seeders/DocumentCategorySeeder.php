<?php

namespace Database\Seeders;

use App\Models\DocumentCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentCategorySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Фриланс',
                'description' => 'Договор, акт и инвойс для разработчиков, дизайнеров и копирайтеров.',
            ],
            [
                'name'        => 'Обучение / репетиторство',
                'description' => 'Договор обучения, график занятий и квитанция для репетиторов и преподавателей.',
            ],
            [
                'name'        => 'Бытовые услуги',
                'description' => 'Договор, акт и счёт для клининга, ремонта и других бытовых услуг.',
            ],
            [
                'name'        => 'Строительство / подряд',
                'description' => 'Договор подряда, смета, акт приёмки и счёт для строительных работ.',
            ],
            [
                'name'        => 'Юридические услуги',
                'description' => 'Договор на юр. услуги, акт, счёт и доверенность.',
            ],
            [
                'name'        => 'Консалтинг',
                'description' => 'Договор на консультацию, план работ, акт и счёт.',
            ],
        ];

        foreach ($categories as $category) {
            DocumentCategory::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
