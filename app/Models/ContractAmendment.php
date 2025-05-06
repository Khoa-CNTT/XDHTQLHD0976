<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Contract;

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
