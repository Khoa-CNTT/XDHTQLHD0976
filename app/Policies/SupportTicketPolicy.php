<?php

namespace App\Policies;

use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
class SupportTicketPolicy
{
    // Admin xem được tất cả, nhân viên chỉ xem ticket được phân công
    public function view(User $user, SupportTicket $ticket)
    {
        return $user->role === 'admin' || ($user->role === 'employee' && $ticket->assigned_employee_id == $user->id);
    }

    // Admin xem danh sách tất cả, nhân viên chỉ xem danh sách ticket được phân công
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin', 'employee']);
    }

    // Chỉ admin được phân công nhân viên
    public function assign(User $user)
    {
        return $user->role === 'admin';
    }

    // Chỉ admin được cập nhật trạng thái
    public function update(User $user, SupportTicket $ticket)
{
    return $user->role === 'admin' || 
           ($user->role === 'employee' && $ticket->assigned_employee_id == $user->id);
}

    // Admin hoặc nhân viên được phản hồi (nhân viên chỉ phản hồi ticket được phân công)
    public function respond(User $user, SupportTicket $ticket)
    {
        return $user->role === 'admin' || ($user->role === 'employee' && $ticket->assigned_employee_id == $user->id);
    }

    // Chỉ admin được tạo mới/chỉnh sửa ticket
    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function edit(User $user, SupportTicket $ticket)
    {
        return $user->role === 'admin';
    }


    // Chỉ admin được xóa ticket
    public function delete(User $user, SupportTicket $ticket)
    {
        return $user->role === 'admin';
    }
}