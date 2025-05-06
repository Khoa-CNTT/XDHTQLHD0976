<?php
namespace App\Policies;

use App\Models\User;
use App\Models\ContractAmendment;

class ContractAmendmentPolicy
{
    /**
     * Determine if the user can view any contract amendments.
     */
    public function viewAny(User $user)
    {
        // Admin và nhân viên có thể xem danh sách phụ lục hợp đồng
        return in_array($user->role, ['admin', 'employee']);
    }

    /**
     * Determine if the user can view a specific contract amendment.
     */
    public function view(User $user, ContractAmendment $contractAmendment)
    {
        // Admin, nhân viên hoặc khách hàng liên quan có thể xem
        return $user->role === 'admin' || $user->role === 'employee' || $user->id === $contractAmendment->contract->customer_id;
    }

    /**
     * Determine if the user can create a contract amendment.
     */
    public function create(User $user)
    {
        // Chỉ admin và nhân viên mới có thể tạo phụ lục hợp đồng
        return in_array($user->role, ['admin', 'employee']);
    }

    /**
     * Determine if the user can update a contract amendment.
     */
    public function update(User $user, ContractAmendment $contractAmendment)
    {
        // Chỉ admin hoặc nhân viên mới có thể sửa phụ lục hợp đồng
        return in_array($user->role, ['admin', 'employee']);
    }

    /**
     * Determine if the user can delete a contract amendment.
     */
    public function delete(User $user, ContractAmendment $contractAmendment)
    {
        // Chỉ admin mới có thể xóa phụ lục hợp đồng
        return $user->role === 'admin';
    }
}