<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasPermissions;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\ActivityLog;
use App\Models\SupportTicket;
use App\Models\Notification;




class User extends Authenticatable
{
    use HasFactory, Notifiable,HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'identity_card','dob', 'password', 'role','status', 'phone', 'address'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    


    /**
     * Lấy tên role (dành cho middleware)
     */
    // Kiểm tra nếu user là customer
    public function isCustomer()
    {
        return $this->role === 'customer';
    }
   // Kiểm tra nếu user là admin
   public function isAdmin()
   {
       return $this->role === 'admin';
   }
   public function isEmployee()
    {
        return $this->role === 'employee';
    }
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }


    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    
     public function getAvatarUrl()
    {
        return $this->avatar
            ? asset('storage/avatars/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name ?? 'User') . '&color=7F9CF5&background=EBF4FF';
    }
public function notifications()
{
    return $this->hasMany(Notification::class);
}

public function unreadNotifications()
{
    return $this->hasMany(Notification::class)->where('is_read', false);
}


}

//Model này dùng để xác định các trường trong bảng users
//ví dụ: protected $fillable = ['name', 'email', 'password', 'role'];
//các trường này sẽ được lấy từ form và lưu vào database
//ví dụ: protected $hidden = ['password', 'remember_token'];
//các trường này sẽ không được hiển thị khi trả về dữ liệu
//ví dụ: protected function casts(): array
//các trường này sẽ được chuyển đổi sang kiểu dữ liệu khác  