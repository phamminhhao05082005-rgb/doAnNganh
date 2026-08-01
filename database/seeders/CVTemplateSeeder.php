<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CVTemplate;

class CVTemplateSeeder extends Seeder
{
    public function run(): void
    {
        CVTemplate::query()->delete();

        CVTemplate::create([
            'name' => 'Classic',
            'description' => 'Mẫu CV truyền thống, phù hợp cho hầu hết ngành nghề.',
            'thumbnail' => 'cv_templates/classic.png',
            'template_path' => 'classic',
            'is_active' => true,
        ]);

        CVTemplate::create([
            'name' => 'Modern',
            'description' => 'Mẫu CV hiện đại với bố cục hai cột.',
            'thumbnail' => 'cv_templates/modern.png',
            'template_path' => 'modern',
            'is_active' => true,
        ]);

        CVTemplate::create([
            'name' => 'Creative',
            'description' => 'Mẫu CV sáng tạo dành cho Designer và Marketing.',
            'thumbnail' => 'cv_templates/creative.png',
            'template_path' => 'creative',
            'is_active' => true,
        ]);
    }
}