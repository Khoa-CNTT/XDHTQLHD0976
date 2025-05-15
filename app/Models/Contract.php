<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $service_id
 * @property int $customer_id
 * @property string $contract_number
 * @property string $start_date
 * @property string $end_date
 * @property string $status
 * @property string $total_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContractAmendment> $amendments
 * @property-read int|null $amendments_count
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContractDocument> $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\Signature|null $latestSignature
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\Service|null $service
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Signature> $signatures
 * @property-read int|null $signatures_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereContractNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'customer_id',
        'contract_number',
        'start_date',
        'end_date',
        'status',
        'total_price',
        'signed_document',
        'payment_status',
        'last_payment_date',
    ];
    

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
        return $this->hasMany(\App\Models\Payment::class);
    }

    public function signatures()
    {
        return $this->hasMany(\App\Models\Signature::class);
    }
    public function amendments()
{
    return $this->hasMany(ContractAmendment::class);
}

public function documents()
{
    return $this->hasMany(ContractDocument::class);
}
public function latestSignature()
{
    return $this->hasOne(Signature::class)->latestOfMany();
}

}
