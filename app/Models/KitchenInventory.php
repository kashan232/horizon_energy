<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KitchenInventory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    // Relationship with KitchenItem
    public function item()
    {
        return $this->belongsTo(KitchenItem::class, 'item_id');
    }
}
