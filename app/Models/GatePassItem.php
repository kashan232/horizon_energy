<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GatePassItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function item()
    {
        return $this->belongsTo(KitchenItem::class, 'item_id');
    }
}
