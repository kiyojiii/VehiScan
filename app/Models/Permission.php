<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions'; // Correct table name

    protected $fillable = [
    'name',
    'guard_name',
    ];
}
