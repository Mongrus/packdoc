<?php

namespace Database\Seeders;

use App\Enums\DocumentType;
use App\Models\DocumentCategory;
use App\Models\DocumentTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentTemplateSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $templates = [
            // ── Фриланс и услуги ──
            [
                'category' => 'Фриланс и услуги',
                'name'     => 'Договор на разработку / дизайн / контент',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Договор на оказание услуг</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Фриланс и услуги',
                'name'     => 'Акт выполненных работ',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Акт выполненных работ</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Фриланс и услуги',
                'name'     => 'Счёт-фактура / инвойс',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Инвойс</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Фриланс и услуги',
                'name'     => 'Договор оказания образовательных услуг',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Договор на образовательные услуги</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Фриланс и услуги',
                'name'     => 'График занятий',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>График занятий</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Фриланс и услуги',
                'name'     => 'Квитанция / счёт',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Квитанция</h1><p>{{ content }}</p>',
            ],

            // ── Мелкий бизнес / сервисные услуги ──
            [
                'category' => 'Мелкий бизнес / сервисные услуги',
                'name'     => 'Договор на оказание услуг (клининг / сервис)',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Договор на оказание услуг</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Мелкий бизнес / сервисные услуги',
                'name'     => 'Акт выполненных работ',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Акт выполненных работ</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Мелкий бизнес / сервисные услуги',
                'name'     => 'Счёт / чек',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Счёт</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Мелкий бизнес / сервисные услуги',
                'name'     => 'Договор подряда (строительство / ремонт)',
                'type'     => DocumentType::Docx,
                'template_html' => '<h1>Договор подряда</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Мелкий бизнес / сервисные услуги',
                'name'     => 'Акт приёмки выполненных работ',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Акт приёмки</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Мелкий бизнес / сервисные услуги',
                'name'     => 'Смета / расчёт стоимости работ',
                'type'     => DocumentType::Docx,
                'template_html' => '<h1>Смета</h1><p>{{ content }}</p>',
            ],

            // ── Консалтинг / юридическая поддержка ──
            [
                'category' => 'Консалтинг / юридическая поддержка',
                'name'     => 'Договор на оказание юридических услуг',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Договор на юридические услуги</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Консалтинг / юридическая поддержка',
                'name'     => 'Акт выполненных работ / оказанных услуг',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Акт оказанных услуг</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Консалтинг / юридическая поддержка',
                'name'     => 'Счёт / инвойс (юридический)',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Инвойс</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Консалтинг / юридическая поддержка',
                'name'     => 'Договор на консультацию',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Договор на консультацию</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Консалтинг / юридическая поддержка',
                'name'     => 'План работ / отчёт',
                'type'     => DocumentType::Docx,
                'template_html' => '<h1>План работ</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Консалтинг / юридическая поддержка',
                'name'     => 'Счёт / квитанция (консалтинг)',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Квитанция</h1><p>{{ content }}</p>',
            ],
        ];

        foreach ($templates as $data) {
            $category = DocumentCategory::where('name', $data['category'])->first();

            if (! $category) {
                continue;
            }

            DocumentTemplate::firstOrCreate(
                ['name' => $data['name'], 'category_id' => $category->id],
                [
                    'type'          => $data['type'],
                    'template_html' => $data['template_html'],
                ]
            );
        }
    }
}
