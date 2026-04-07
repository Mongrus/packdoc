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
            // ── Фриланс ──
            [
                'category' => 'Фриланс',
                'name'     => 'Договор на фриланс-услуги',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Договор на оказание фриланс-услуг</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Фриланс',
                'name'     => 'Акт выполненных работ (фриланс)',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Акт выполненных работ</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Фриланс',
                'name'     => 'Инвойс (фриланс)',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Инвойс</h1><p>{{ content }}</p>',
            ],

            // ── Обучение / репетиторство ──
            [
                'category' => 'Обучение / репетиторство',
                'name'     => 'Договор обучения',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Договор обучения</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Обучение / репетиторство',
                'name'     => 'График занятий',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>График занятий</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Обучение / репетиторство',
                'name'     => 'Квитанция',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Квитанция</h1><p>{{ content }}</p>',
            ],

            // ── Бытовые услуги ──
            [
                'category' => 'Бытовые услуги',
                'name'     => 'Договор на бытовые услуги',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Договор на оказание бытовых услуг</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Бытовые услуги',
                'name'     => 'Акт выполненных работ (бытовые)',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Акт выполненных работ</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Бытовые услуги',
                'name'     => 'Счёт за услуги',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Счёт</h1><p>{{ content }}</p>',
            ],

            // ── Строительство / подряд ──
            [
                'category' => 'Строительство / подряд',
                'name'     => 'Договор подряда',
                'type'     => DocumentType::Docx,
                'template_html' => '<h1>Договор подряда</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Строительство / подряд',
                'name'     => 'Смета на работы',
                'type'     => DocumentType::Docx,
                'template_html' => '<h1>Смета</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Строительство / подряд',
                'name'     => 'Акт приёмки работ',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Акт приёмки</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Строительство / подряд',
                'name'     => 'Счёт за подрядные работы',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Счёт</h1><p>{{ content }}</p>',
            ],

            // ── Юридические услуги ──
            [
                'category' => 'Юридические услуги',
                'name'     => 'Договор на юридические услуги',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Договор на юридические услуги</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Юридические услуги',
                'name'     => 'Акт оказанных юридических услуг',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Акт оказанных услуг</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Юридические услуги',
                'name'     => 'Счёт за юридические услуги',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Счёт</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Юридические услуги',
                'name'     => 'Доверенность',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Доверенность</h1><p>{{ content }}</p>',
            ],

            // ── Консалтинг ──
            [
                'category' => 'Консалтинг',
                'name'     => 'Договор на консультацию',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Договор на консультацию</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Консалтинг',
                'name'     => 'План работ / отчёт',
                'type'     => DocumentType::Docx,
                'template_html' => '<h1>План работ</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Консалтинг',
                'name'     => 'Счёт за консультацию',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Счёт</h1><p>{{ content }}</p>',
            ],
            [
                'category' => 'Консалтинг',
                'name'     => 'Акт оказанных консалтинговых услуг',
                'type'     => DocumentType::Pdf,
                'template_html' => '<h1>Акт оказанных услуг</h1><p>{{ content }}</p>',
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
