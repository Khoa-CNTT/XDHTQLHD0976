<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportResponse extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'support_ticket_id',
        'user_id',
        'content',
    ];
    
    /**
     * Lấy yêu cầu hỗ trợ liên quan đến phản hồi này
     */
    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id');
    }
    
    /**
     * Lấy người dùng đã tạo phản hồi này
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Kiểm tra xem phản hồi này có phải của nhân viên/admin hay không
     */
    public function isStaff()
    {
        return $this->user && ($this->user->role === 'admin' || $this->user->role === 'employee');
    }
} 