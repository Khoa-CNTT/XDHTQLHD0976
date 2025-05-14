<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;

    protected $fillable = [ 
    'contract_id',
    'customer_name',
    'customer_email',
    'signature_data',
    'contract_duration_id', 
    'status',
    'signed_at',
    'signature_image', 
    'otp_verified_at',
    'admin_signature_data',
    'admin_signature_image',
    'admin_signed_at',
    'admin_name',
    'admin_position',
];
public function getSignatureImageUrlAttribute()
{
    return $this->signature_image ? asset('storage/signatures/' . $this->signature_image) : null;
}
public function isSignedByCustomer()
{
    return !empty($this->signature_data);
}

public function isSignedByAdmin()
{
    return !empty($this->admin_signature_data);
}

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
    
    public function contractDuration()
    {
        return $this->belongsTo(ContractDuration::class);
    }

    /**
     * Kiểm tra xem hợp đồng đã được ký bởi cả hai bên chưa
     */
   public function isFullySigned()
{
    return !empty($this->signature_data) && !empty($this->admin_signature_data);
}
}
