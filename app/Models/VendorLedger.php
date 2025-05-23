<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorLedger extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
