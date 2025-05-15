<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Contract;

/**
 * 
 *
 * @property int $id
 * @property int $contract_id
 * @property string $amendment_reason
 * @property string $changes_made
 * @property string $effective_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Contract $contract
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractAmendment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractAmendment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractAmendment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractAmendment whereAmendmentReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractAmendment whereChangesMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractAmendment whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractAmendment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractAmendment whereEffectiveDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractAmendment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractAmendment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContractAmendment extends Model
{
    use HasFactory;
    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'employee']);
    }

    protected $fillable = [
        'contract_id',
        'amendment_reason',
        'changes_made',
        'effective_date',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
