<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'driver_name',
        'driver_license_image',
        'authorized_driver_name',
        'authorized_driver_address',
        'authorized_driver_license_image',
        'approval_status',
    ];

    // Relationships
    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }
}
