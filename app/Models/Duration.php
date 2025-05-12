<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ContractDuration;

class Duration extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'months'];

    /**
     * Quan hệ với bảng `contract_durations`
     */
    public function contractDurations()
    {
        return $this->hasMany(ContractDuration::class);
    }
}