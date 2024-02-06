<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statuses extends Model
{
    protected $fillable = ['applicant_role_status'];

    // Relationships
    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'status_id');
    }
}
