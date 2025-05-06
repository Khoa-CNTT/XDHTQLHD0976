<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services'; 
    protected $fillable = ['service_name', 'description', 'content', 'price', 'created_by', 'image', 'is_hot', 'category_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
    public function reviews()
{
    return $this->hasMany(ServiceReview::class);
}

public function category()
{
    return $this->belongsTo(ServiceCategory::class, 'category_id');
}
}
