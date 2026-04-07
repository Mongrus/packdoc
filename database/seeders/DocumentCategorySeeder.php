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
                'name'        => 'Фриланс и услуги',
                'description' => 'Договоры, акты и счета для разработчиков, дизайнеров, копирайтеров, репетиторов и других специалистов.',
            ],
            [
                'name'        => 'Мелкий бизнес / сервисные услуги',
                'description' => 'Пакеты для клининга, ремонта, строительства и других сервисных направлений.',
            ],
            [
                'name'        => 'Консалтинг / юридическая поддержка',
                'description' => 'Документы для юристов, консультантов и маркетинговых агентств.',
            ],
        ];

        foreach ($categories as $category) {
            DocumentCategory::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
