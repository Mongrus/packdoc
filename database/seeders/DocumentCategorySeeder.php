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
            ['name' => 'Фриланс', 'description' => 'Документы для фриланс-услуг: разработка, дизайн, копирайтинг и др.'],
            ['name' => 'Уборка', 'description' => 'Договоры и акты для клининговых услуг.'],
            ['name' => 'Обучение', 'description' => 'Документы для репетиторов, тренеров и образовательных услуг.'],
            ['name' => 'Строительство и ремонт', 'description' => 'Сметы, акты и договоры подряда.'],
            ['name' => 'Консалтинг', 'description' => 'Договоры на консультационные и экспертные услуги.'],
            ['name' => 'Юридические услуги', 'description' => 'Шаблоны для юристов и нотариусов.'],
            ['name' => 'Медицина и здоровье', 'description' => 'Документы для частных врачей, массажистов и тренеров.'],
            ['name' => 'Транспорт и логистика', 'description' => 'Накладные, путевые листы, договоры перевозки.'],
        ];

        foreach ($categories as $category) {
            DocumentCategory::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
