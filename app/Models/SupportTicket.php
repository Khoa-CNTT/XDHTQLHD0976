<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
/**
 * 
 *
 * @property \App\Models\User $user
 * @property int $id
 * @property int $user_id
 * @property int|null $assigned_employee_id
 * @property string $title
 * @property string $content
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SupportResponse> $responses
 * @property-read int|null $responses_count
 * @property-read \App\Models\User|null $staff
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicket query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicket whereAssignedEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicket whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicket whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicket whereUserId($value)
 * @mixin \Eloquent
 */
class SupportTicket extends Model
{
    protected $table = 'support_tickets';
    protected $fillable = [
        'user_id','assigned_employee_id', 'title', 'content', 'status',
    ];
    
    protected $dates = ['created_at', 'updated_at'];
    
     public function staff()
    {
        return $this->belongsTo(User::class, 'assigned_employee_id');
    }
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
