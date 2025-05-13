<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'position', 'department', 'salary', 'hired_date'];

    /**
     * Get the user that owns the employee record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the services created by the employee.
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'created_by');
    }
    
    /**
     * Mutator for salary attribute to ensure it's always stored as a number.
     * 
     * @param mixed $value
     * @return void
     */
    public function setSalaryAttribute($value)
    {
        // Remove any non-numeric characters (like commas, dots) except decimal point
        $this->attributes['salary'] = is_numeric($value) ? $value : preg_replace('/[^0-9]/', '', $value);
    }
}

