<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 
 *
 * @property int $id
 * @property int $service_id
 * @property int $customer_id
 * @property int $rating
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer|null $customer
 * @property-read \App\Models\Service|null $service
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceReview query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceReview whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceReview whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceReview whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceReview whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceReview whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServiceReview extends Model
{
    use HasFactory;
    
    protected $fillable = ['service_id', 'customer_id', 'rating', 'comment'];
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
