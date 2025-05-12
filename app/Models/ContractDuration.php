<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use App\Models\Duration;

class ContractDuration extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'duration_id', 'price'];

    /**
     * Quan hệ với bảng `services`
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Quan hệ với bảng `durations`
     */
    public function duration()
    {
        return $this->belongsTo(Duration::class);
    }
}