<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ContractDuration;

/**
 * 
 *
 * @property int $id
 * @property string $label
 * @property int $months
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ContractDuration> $contractDurations
 * @property-read int|null $contract_durations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Duration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Duration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Duration query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Duration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Duration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Duration whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Duration whereMonths($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Duration whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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