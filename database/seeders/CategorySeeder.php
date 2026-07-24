<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            'Phục vụ nhà hàng',

            'Thu ngân',

            'Bán hàng',

            'Nhân viên siêu thị',

            'Pha chế',

            'Giao hàng',

            'Gia sư',

            'Nhập liệu',

            'CSKH',

            'Marketing',

            'Content Creator',

            'Thiết kế đồ họa',

            'Lập trình viên',

            'Tester',

            'Chăm sóc thú cưng',

            'Nhân viên kho',

            'Lễ tân',

            'Hướng dẫn viên',

            'Trợ giảng',

            'Khác'

        ];

        foreach ($categories as $item) {

            Category::create([
                'name' => $item
            ]);

        }
    }
}