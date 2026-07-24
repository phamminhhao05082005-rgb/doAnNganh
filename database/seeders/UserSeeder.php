<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'role_id' => 1,
            'full_name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => '123456',
            'phone' => '0900000001',
            'status' => true,
        ]);

        for ($i = 1; $i <= 3; $i++) {

            User::create([
                'role_id' => 2,
                'full_name' => "Student $i",
                'email' => "student$i@gmail.com",
                'password' => '123456',
                'phone' => "09000000$i",
                'status' => true,
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {

            User::create([
                'role_id' => 3,
                'full_name' => "Employer $i",
                'email' => "company$i@gmail.com",
                'password' => '123456',
                'phone' => "09100000$i",
                'status' => true,
            ]);
        }
    }
}