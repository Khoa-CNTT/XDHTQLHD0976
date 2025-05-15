<?php

// app/Models/Customer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $company_name
 * @property string $tax_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contract> $contracts
 * @property-read int|null $contracts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ServiceReview> $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereTaxCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUserId($value)
 * @mixin \Eloquent
 */
class Customer extends Model
{
    use HasFactory;

    // Chỉ định bảng mà model này sẽ liên kết đến (nếu tên bảng không tuân theo quy ước Laravel)
    protected $table = 'customers';

    // Các trường có thể được gán giá trị
    protected $fillable = ['user_id', 'company_name', 'tax_code'];

    // Thiết lập quan hệ với model User (một khách hàng thuộc một người dùng)
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
    
    public function contracts()
{
    return $this->hasMany(Contract::class, 'customer_id');
}

public function payments()
{
    return $this->hasManyThrough(Payment::class, Contract::class);
}

public function reviews()
{
    return $this->hasMany(ServiceReview::class);
}
}
