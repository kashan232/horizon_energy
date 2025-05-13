<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;


class Deal extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
  // In Deal model
public function product()
{
    return $this->belongsToMany(Product::class,'product');
}


}
