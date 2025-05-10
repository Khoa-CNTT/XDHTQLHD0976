<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SupportTicket extends Model
{
    protected $table = 'support_tickets';
    protected $fillable = [
        'user_id', 'title', 'content', 'status',
    ];
    
    protected $dates = ['created_at', 'updated_at'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Lấy danh sách phản hồi cho yêu cầu hỗ trợ này
     */
    public function responses()
    {
        return $this->hasMany(SupportResponse::class, 'support_ticket_id');
    }
    
    /**
     * Kiểm tra xem yêu cầu hỗ trợ này đã được phản hồi bởi nhân viên hay chưa
     */
    public function hasStaffResponse()
    {
        return $this->responses()->whereHas('user', function($query) {
            $query->whereIn('role', ['admin', 'employee']);
        })->exists();
    }
}
