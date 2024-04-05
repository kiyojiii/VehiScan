<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'user_id',
        'driver_id',
        'owner_id',
        'violation_id',
        'time_status_id',
        'official_receipt_image',
        'certificate_of_registration_image',
        'deed_of_sale_image',
        'authorization_letter_image',
        'qr_image',
        'owner_name',
        'owner_address',
        'plate_number',
        'vehicle_make',
        'front_photo',
        'side_photo',
        'year_model',
        'color',
        'body_type',
        'approval_status',
        'reason',   
        'registration_status',
        'vehicle_code',
    ];

    // Relationships
    public function owner()
    {
        return $this->belongsTo(Applicant::class, 'owner_id');
    }
    
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function violation()
    {
        return $this->belongsTo(Violation::class, 'violation_id');
    }

    public function time()
    {
        return $this->belongsTo(Time::class, 'time_id');
    }
}