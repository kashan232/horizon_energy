<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StaffSalary;
class Staff extends Model
{

    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function salaries()
    {
        return $this->belongsTo(StaffSalary::class, 'staff_id');
    }
}


