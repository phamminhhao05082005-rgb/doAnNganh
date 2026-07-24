<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [

            'Giao tiếp',

            'Tiếng Anh',

            'Tin học văn phòng',

            'Excel',

            'Word',

            'PowerPoint',

            'Java',

            'Spring Boot',

            'ReactJS',

            'Laravel',

            'PHP',

            'JavaScript',

            'MySQL',

            'Photoshop',

            'Canva',

            'Content Writing',

            'SEO',

            'Pha chế',

            'Bán hàng',

            'Chăm sóc khách hàng',

            'Làm việc nhóm',

            'Thuyết trình',

            'Lập kế hoạch',

            'Quản lý thời gian',

            'Giải quyết vấn đề'

        ];

        foreach ($skills as $item) {

            Skill::create([
                'name' => $item
            ]);

        }
    }
}