<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'service_id', 'contract_number', 'start_date', 'end_date', 'status', 'total_price', 'signed_document'];
    

    // Quan hệ với user (khách hàng)
    public function customer() {
        return $this->belongsTo(Customer::class);
    }
    public function service() {
        return $this->belongsTo(Service::class);
    }
    

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function signature()
    {
        return $this->hasOne(Signature::class);
    }

}
