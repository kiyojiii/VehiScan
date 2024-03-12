<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle_Record extends Model
{
    protected $table = 'vehicle_record'; // Correct table name

    protected $fillable = [
        'user_id',
        'driver_id',
        'status_id',
        'appointment_id',
        'vehicle_id',
        'owner_id',
        'remarks',
    ];

    // Relationships
    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'owner_id');
    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function status()
    {
        return $this->belongsTo(Statuses::class, 'status_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }    

    public function driver()
    {
        return $this->hasOne(Driver::class, 'driver_id');
    }
}
