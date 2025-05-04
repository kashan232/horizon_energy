<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public static function generateInvoiceNo()
    {
        // Define the prefix for the invoice number
        $prefix = 'INVPURC-';

        // Fetch the last invoice number from the database
        $lastInvoice = self::orderBy('id', 'desc')->first();

        // Extract the last number, default to 0 if no previous record exists
        $lastNumber = $lastInvoice ? (int)substr($lastInvoice->invoice_no, strlen($prefix)) : 0;

        // Increment the last number and format it with leading zeros
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        // Return the new invoice number
        return $prefix . $newNumber;
    }

}
