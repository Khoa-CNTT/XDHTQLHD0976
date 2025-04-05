<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\User;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        // Tạo người dùng trước
        $user1 = User::create([
            'name' => 'Nguyễn Văn A',
            'email' => 'nguyenvana@example.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
        ]);

        $user2 = User::create([
            'name' => 'Trần Thị B',
            'email' => 'tranthib@example.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
        ]);

        // Tạo nhân viên liên kết với người dùng
        Employee::create([
            'user_id' => $user1->id,
            'position' => 'Nhân viên IT',
            'department' => 'Công nghệ thông tin',
            'salary' => 10000000,
            'hired_date' => '2025-04-01',
        ]);

        Employee::create([
            'user_id' => $user2->id,
            'position' => 'Nhân viên Kế toán',
            'department' => 'Kế toán',
            'salary' => 8000000,
            'hired_date' => '2025-03-15',
        ]);
    }
}