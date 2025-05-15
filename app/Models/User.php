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

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $identity_card
 * @property string $dob
 * @property string $password
 * @property string $role
 * @property string $status
 * @property string|null $phone
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $avatar
 * @property string|null $remember_token
 * @property string|null $last_login_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ActivityLog> $activityLogs
 * @property-read int|null $activity_logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, SupportTicket> $assignedTickets
 * @property-read int|null $assigned_tickets_count
 * @property-read Customer|null $customer
 * @property-read Employee|null $employee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, SupportTicket> $supportTickets
 * @property-read int|null $support_tickets_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Notification> $unreadNotifications
 * @property-read int|null $unread_notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIdentityCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */


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
    return $this->hasMany(SupportTicket::class, 'user_id', 'id');
}

    
         
      
public function getAvatarUrl()
{
    return $this->avatar 
        ? asset('storage/' . $this->avatar) 
        : asset('images/default-avatar.png');
}

public function notifications()
{
    return $this->hasMany(Notification::class);
}

public function unreadNotifications()
{
    return $this->hasMany(Notification::class)->where('is_read', false);
}
public function assignedTickets()
{
    return $this->hasMany(SupportTicket::class, 'assigned_employee_id');
}

}

