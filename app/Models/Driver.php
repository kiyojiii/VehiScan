<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'user_id',
        'driver_name',
        'driver_license_image',
        'authorized_driver_name',
        'authorized_driver_address',
        'authorized_driver_license_image',
        'reason',
        'approval_status',
    ];

}
