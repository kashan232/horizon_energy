<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Expense extends Model
{
    protected $table = 'expenses';
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

     public function user()
    {
        return $this->belongsTo(User::class, 'admin_or_user_id');
    }
}
