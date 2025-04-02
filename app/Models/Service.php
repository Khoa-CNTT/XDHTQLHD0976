<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['service_name', 'description', 'service_type', 'price', 'created_by'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
