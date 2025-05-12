<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceReview extends Model
{
    use HasFactory;
    
    protected $fillable = ['service_id', 'customer_id', 'rating', 'comment'];
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
