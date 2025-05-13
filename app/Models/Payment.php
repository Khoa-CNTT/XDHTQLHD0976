<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

   protected $fillable = [
    'contract_id',
    'contract_duration_id',
    'amount',
    'date',
    'method',
    'transaction_id',
    'order_id',
    'payment_type',
    'payment_response',
    'ipn_response',
    'error_message', 
    'status'    
];


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
        'amount' => 'decimal:2',
    ];


    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
