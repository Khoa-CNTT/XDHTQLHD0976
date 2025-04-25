<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [ 'service_id', 'customer_id',
    'contract_number', 'start_date', 'end_date', 'status', 'total_price', 'signed_document'];
    

    // Quan hệ với user (khách hàng)
    public function customer()
{
    return $this->belongsTo(Customer::class, 'customer_id');
}
    public function service() {
        return $this->belongsTo(Service::class);
    }
    

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function signatures()
    {
        return $this->hasMany(Signature::class, 'contract_id');
    }

}
