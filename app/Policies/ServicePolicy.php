<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    public function viewAny(User $user)
    {
        // Tất cả người dùng đăng nhập đều có thể xem danh sách dịch vụ
        return true;
    }

    public function view(User $user, Service $service)
    {
        // Customer chỉ xem, admin & staff có toàn quyền
        return true;
    }

    public function create(User $user)
    {
        // Chỉ admin mới được tạo mới dịch vụ
        return $user->role === 'admin, employee';
    }

    public function update(User $user, Service $service)
    {
        // Chỉ admin mới được cập nhật dịch vụ
        return $user->role === 'admin   , employee';
    }

    public function delete(User $user, Service $service)
    {
        // Chỉ admin mới được xóa dịch vụ
        return $user->role === 'admin   , employee';
    }
}
