<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $contract_id
 * @property int $contract_duration_id
 * @property numeric $amount
 * @property \Illuminate\Support\Carbon $date
 * @property string $method
 * @property string|null $transaction_id
 * @property string|null $order_id
 * @property string|null $payment_type
 * @property string|null $payment_response
 * @property string|null $request_id
 * @property string|null $partner_code
 * @property string|null $signature
 * @property string|null $ipn_response
 * @property string|null $error_message
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contract|null $contract
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereContractDurationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereErrorMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereIpnResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePartnerCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePaymentResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
