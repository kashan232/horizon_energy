<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffSalary extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Relationship with Staff
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
