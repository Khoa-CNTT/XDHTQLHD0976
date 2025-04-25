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
    'identity_card',
    'duration', // Thời hạn hợp đồng
        'status',
    'signed_at',
];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
