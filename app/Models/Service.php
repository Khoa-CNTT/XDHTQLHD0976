<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Duration;

/**
 * 
 *
 * @property int $id
 * @property string $service_name
 * @property string $description
 * @property string|null $content
 * @property string|null $image
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_hot
 * @property int|null $category_id
 * @property string|null $deleted_at
 * @property-read \App\Models\ServiceCategory|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContractDuration> $contractDurations
 * @property-read int|null $contract_durations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contract> $contracts
 * @property-read int|null $contracts_count
 * @property-read \App\Models\Employee|null $employee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ServiceReview> $reviews
 * @property-read int|null $reviews_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereIsHot($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereServiceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Service extends Model
{
    use HasFactory;

    protected $table = 'services'; 
    protected $fillable = [
        'service_name', 
        'description', 
        'content', 
        'created_by', 
        'image', 
        'is_hot', 
        'category_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
    public function reviews()
{
    return $this->hasMany(ServiceReview::class);
}

public function category()
{
    return $this->belongsTo(ServiceCategory::class, 'category_id');
}
 public function contractDurations()
    {
        return $this->hasMany(ContractDuration::class);
    }
    
    /**
     * Get all available durations for this service
     */
    public function durations()
    {
        return Duration::whereIn('id', $this->contractDurations()->pluck('duration_id'))->orderBy('months', 'asc')->get();
    }
    
    /**
     * Get price for a specific duration
     */
    public function getPriceForDuration($durationId)
    {
        $contractDuration = $this->contractDurations()->where('duration_id', $durationId)->first();
        return $contractDuration ? $contractDuration->price : null;
    }
    
    /**
     * Check if this service has any durations set up
     */
    public function hasDurations()
    {
        return $this->contractDurations()->exists();
    }
}
