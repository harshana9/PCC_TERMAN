<?php

namespace App\Models\StockFlow\PCC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueToVendorUsed_Items extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_to_vendor_used',
        'product_name',
        'connection_type',
        'description',
        'serial_first',
        'serial_last',
        'quantity'
    ];
}
