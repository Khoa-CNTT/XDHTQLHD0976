<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $support_ticket_id
 * @property int $user_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SupportTicket $ticket
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportResponse whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportResponse whereSupportTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportResponse whereUserId($value)
 * @mixin \Eloquent
 */
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