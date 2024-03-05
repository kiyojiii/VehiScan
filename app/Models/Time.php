<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $fillable = [
    'time_in', 
    'time_out',
    'vehicle_id',
    ];

    // Relationships
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }    
}
