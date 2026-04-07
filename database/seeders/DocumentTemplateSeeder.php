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
            [
                'category' => 'Фриланс',
                'name' => 'Договор на разработку',
                'type' => DocumentType::Pdf,
                'template_html' => <<<HTML
<h1>Договор на оказание услуг по разработке</h1>
<p>Исполнитель: <strong>{{ fio }}</strong></p>
<p>Клиент: <strong>{{ client_name }}</strong></p>
<p>Описание работ: {{ description }}</p>
<p>Стоимость: <strong>{{ price }} руб.</strong></p>
<p>Срок выполнения: {{ deadline }}</p>
<p>Дата заключения: {{ date }}</p>
HTML,
            ],
            [
                'category' => 'Фриланс',
                'name' => 'Акт выполненных работ',
                'type' => DocumentType::Pdf,
                'template_html' => <<<HTML
<h1>Акт выполненных работ</h1>
<p>Исполнитель: <strong>{{ fio }}</strong></p>
<p>Клиент: <strong>{{ client_name }}</strong></p>
<p>Работы выполнены в полном объёме. Сумма к оплате: <strong>{{ price }} руб.</strong></p>
<p>Дата: {{ date }}</p>
HTML,
            ],
            [
                'category' => 'Строительство и ремонт',
                'name' => 'Договор подряда',
                'type' => DocumentType::Docx,
                'template_html' => <<<HTML
<h1>Договор строительного подряда</h1>
<p>Подрядчик: <strong>{{ fio }}</strong></p>
<p>Заказчик: <strong>{{ client_name }}</strong></p>
<p>Объект: {{ address }}</p>
<p>Сметная стоимость: <strong>{{ price }} руб.</strong></p>
<p>Срок выполнения: {{ deadline }}</p>
<p>Дата: {{ date }}</p>
HTML,
            ],
            [
                'category' => 'Консалтинг',
                'name' => 'Договор на консультационные услуги',
                'type' => DocumentType::Pdf,
                'template_html' => <<<HTML
<h1>Договор на оказание консультационных услуг</h1>
<p>Консультант: <strong>{{ fio }}</strong></p>
<p>Клиент: <strong>{{ client_name }}</strong></p>
<p>Предмет консультации: {{ subject }}</p>
<p>Стоимость: <strong>{{ price }} руб.</strong></p>
<p>Дата: {{ date }}</p>
HTML,
            ],
            [
                'category' => 'Обучение',
                'name' => 'Договор на оказание образовательных услуг',
                'type' => DocumentType::Pdf,
                'template_html' => <<<HTML
<h1>Договор на образовательные услуги</h1>
<p>Преподаватель: <strong>{{ fio }}</strong></p>
<p>Ученик / Представитель: <strong>{{ client_name }}</strong></p>
<p>Предмет: {{ subject }}</p>
<p>Количество занятий: {{ lessons_count }}</p>
<p>Стоимость: <strong>{{ price }} руб.</strong></p>
<p>Дата: {{ date }}</p>
HTML,
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
                    'type' => $data['type'],
                    'template_html' => $data['template_html'],
                ]
            );
        }
    }
}
