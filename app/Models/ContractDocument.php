<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
