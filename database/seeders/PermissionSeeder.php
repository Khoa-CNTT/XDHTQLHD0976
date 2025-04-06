<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'create-service', 'description' => 'Tạo mới dịch vụ'],
            ['name' => 'update-service', 'description' => 'Cập nhật dịch vụ'],
            ['name' => 'delete-service', 'description' => 'Xóa dịch vụ'],
            ['name' => 'view-service',   'description' => 'Xem dịch vụ'],
                 ];
             // Thêm các quyền khác tùy theo chức năng hệ thống: hợp đồng, thanh toán, …\n
             foreach ($permissions as $permission) {
                DB::table('permissions')->updateOrInsert(
                    ['name' => $permission['name']],
                    ['description' => $permission['description']]
                );
            }
    }
}
