<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = [
    'user_id',
    'title',
    'message',
    'is_read',
    'created_by',
    'type',
];
  
    protected $dates = ['created_at', 'updated_at'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 