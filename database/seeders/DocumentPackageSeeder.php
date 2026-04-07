<?php

namespace Database\Seeders;

use App\Enums\DocumentPackageStatus;
use App\Models\DocumentPackage;
use App\Models\DocumentTemplate;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentPackageSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $users = User::all();
        $templates = DocumentTemplate::all();

        if ($users->isEmpty() || $templates->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            $templates->random(min(2, $templates->count()))->each(function ($template) use ($user) {
                DocumentPackage::factory()->create([
                    'user_id' => $user->id,
                    'template_id' => $template->id,
                    'status' => DocumentPackageStatus::Completed,
                    'data' => [
                        'fio' => $user->name,
                        'client_name' => 'ООО «Пример»',
                        'price' => rand(5000, 50000),
                        'date' => now()->format('d.m.Y'),
                        'description' => 'Услуги по договору',
                    ],
                    'file_path' => 'packages/' . \Str::uuid() . '.pdf',
                ]);
            });

            DocumentPackage::factory()->draft()->create([
                'user_id' => $user->id,
                'template_id' => $templates->random()->id,
                'data' => [
                    'fio' => $user->name,
                    'client_name' => '',
                    'price' => null,
                    'date' => now()->format('d.m.Y'),
                ],
            ]);
        }
    }
}
