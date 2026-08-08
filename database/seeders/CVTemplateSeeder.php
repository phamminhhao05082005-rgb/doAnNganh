<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CVTemplate;

class CVTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Classic',
                'description' => 'Mẫu CV truyền thống, phù hợp cho hầu hết ngành nghề.',
                'thumbnail' => 'cv_templates/classic.png',
                'template_path' => 'classic',
                'is_active' => true,
            ],
            [
                'name' => 'Modern',
                'description' => 'Mẫu CV hiện đại với bố cục hai cột.',
                'thumbnail' => 'cv_templates/modern.png',
                'template_path' => 'modern',
                'is_active' => true,
            ],
            [
                'name' => 'Creative',
                'description' => 'Mẫu CV sáng tạo dành cho Designer và Marketing.',
                'thumbnail' => 'cv_templates/creative.png',
                'template_path' => 'creative',
                'is_active' => true,
            ],
            
            [
                'name' => 'Minimalist',
                'description' => 'Mẫu CV tối giản, tập trung vào nội dung và sự tinh tế.',
                'thumbnail' => 'cv_templates/minimalist.png',
                'template_path' => 'minimalist',
                'is_active' => true,
            ],
            [
                'name' => 'Professional',
                'description' => 'Mẫu CV chuyên nghiệp dành cho vị trí quản lý và cấp cao.',
                'thumbnail' => 'cv_templates/professional.png',
                'template_path' => 'professional',
                'is_active' => true,
            ],
            [
                'name' => 'Tech',
                'description' => 'Mẫu CV tối ưu cho Lập trình viên và nhân sự ngành Công nghệ.',
                'thumbnail' => 'cv_templates/tech.png',
                'template_path' => 'tech',
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            CVTemplate::updateOrCreate(
                ['template_path' => $template['template_path']], 
                $template
            );
        }
    }
}