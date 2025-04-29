<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'amount',
        'date',
        'method',
        'status',
        'order_id',
        'transaction_id',
        'response_message',
        'payment_type',
        'ipn_received',
    ];


    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
