<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;

    protected $fillable = ['contract_id', 'signature_data', 'signed_at'];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
