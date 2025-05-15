<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use App\Models\Duration;

/**
 * 
 *
 * @property int $id
 * @property int $service_id
 * @property int $duration_id
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Duration $duration
 * @property-read Service $service
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDuration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDuration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDuration query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDuration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDuration whereDurationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDuration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDuration wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDuration whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractDuration whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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