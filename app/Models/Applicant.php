<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'appointment_id',
        'status_id',
        'serial_number',
        'id_number',
        'last_name',
        'first_name',
        'middle_initial',
        'present_address',
        'email_address',
        'contact_number',
        'office_department_agency',
        'position_designation',
        'reason',
        'scan_or_photo_of_id',
        'approval_status',
    ];

    // Relationships

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
        return $this->hasOne(Driver::class, 'applicant_id');
    }
}
