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
        'transaction_id',
        'order_id',
        'payment_type',
        'payment_response',
        'request_id'
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
