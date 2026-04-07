<?php

namespace Database\Seeders;

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
        $user = User::first();
        $templates = DocumentTemplate::all();

        if (! $user || $templates->isEmpty()) {
            return;
        }

        DocumentPackage::factory()->completed()->create([
            'user_id'     => $user->id,
            'template_id' => $templates->firstWhere('name', 'Договор на разработку / дизайн / контент')?->id ?? $templates->first()->id,
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
            'template_id' => $templates->firstWhere('name', 'Договор на консультацию')?->id ?? $templates->last()->id,
            'data'        => [
                'fio'         => $user->name,
                'client_name' => '',
                'price'       => null,
                'date'        => now()->format('d.m.Y'),
            ],
        ]);
    }
}
