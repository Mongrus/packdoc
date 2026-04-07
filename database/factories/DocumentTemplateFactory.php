<?php

namespace Database\Factories;

use App\Enums\DocumentType;
use App\Models\DocumentCategory;
use App\Models\DocumentTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DocumentTemplate>
 */
class DocumentTemplateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => DocumentCategory::factory(),
            'name' => fake()->words(3, true),
            'template_html' => '<p>Договор между {{ fio }} и {{ company }}.<br>Сумма: {{ price }} руб.<br>Дата: {{ date }}</p>',
            'type' => fake()->randomElement(DocumentType::cases()),
        ];
    }
}
