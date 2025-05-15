<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $contract_id
 * @property string $customer_name
 * @property string $customer_email
 * @property string $signature_data
 * @property int|null $contract_duration_id
 * @property string $status
 * @property string $signed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $signature_image Ảnh chữ ký dạng Base64
 * @property string|null $admin_signature_data Dữ liệu chữ ký admin dạng Base64
 * @property string|null $admin_signature_image Ảnh chữ ký admin dạng Base64
 * @property string|null $admin_signed_at Thời gian admin ký hợp đồng
 * @property string|null $admin_name Tên người đại diện bên A
 * @property string|null $admin_position Chức vụ người đại diện bên A
 * @property string|null $otp_verified_at Thời gian OTP được xác nhận
 * @property-read \App\Models\Contract|null $contract
 * @property-read \App\Models\ContractDuration|null $contractDuration
 * @property-read mixed $signature_image_url
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereAdminName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereAdminPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereAdminSignatureData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereAdminSignatureImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereAdminSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereContractDurationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereCustomerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereOtpVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereSignatureData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereSignatureImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
