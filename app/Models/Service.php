<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Duration;

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
