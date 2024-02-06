<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['appointment'];

    // Relationships
    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }
}
