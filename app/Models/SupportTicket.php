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
}
