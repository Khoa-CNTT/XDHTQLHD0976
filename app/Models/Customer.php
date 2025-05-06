<?php

// app/Models/Customer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
public function reviews()
{
    return $this->hasMany(ServiceReview::class);
}
}
