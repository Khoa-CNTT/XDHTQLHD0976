<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $contract_id
 * @property string $document_name
 * @property string $file_path
 * @property int $uploaded_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contract|null $contract
 * @property-read \App\Models\User|null $uploadedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDocument whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDocument whereDocumentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDocument whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDocument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDocument whereUploadedBy($value)
 * @mixin \Eloquent
 */
class ContractDocument extends Model
{
    public function contract()
{
    return $this->belongsTo(Contract::class);
}

public function uploadedBy()
{
    return $this->belongsTo(User::class, 'uploaded_by');
}
}
