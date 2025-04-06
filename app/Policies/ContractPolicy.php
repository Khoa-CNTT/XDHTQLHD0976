<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Contract;

class ContractPolicy
{
    public function viewAny(User $user)
    {
        // Admin và staff có thể xem danh sách hợp đồng
        return in_array($user->role, ['admin', 'employee']);
    }

    public function view(User $user, Contract $contract)
    {
        // Admin, staff hoặc chính khách hàng sở hữu hợp đồng mới được xem
        return $user->role === 'admin' || $user->role === 'employee' || $user->id === $contract->customer_id;
    }

    public function create(User $user)
    {
        // Chỉ admin và staff mới có thể tạo hợp đồng
        return in_array($user->role, ['admin', 'employee']);
    }

    public function update(User $user, Contract $contract)
    {
        // Chỉ admin hoặc staff mới có quyền sửa hợp đồng
        return in_array($user->role, ['admin', 'employee']);
    }

    public function delete(User $user, Contract $contract)
    {
        // Chỉ admin mới có thể xóa hợp đồng
        return $user->role === 'admin';
    }
}
