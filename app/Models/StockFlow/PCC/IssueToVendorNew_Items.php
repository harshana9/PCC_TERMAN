<?php

namespace App\Models\StockFlow\PCC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueToVendorNew_Items extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_to_vendor_new',
        'product_name',
        'connection_type',
        'description',
        'serial_first',
        'serial_last',
        'quantity'
    ];
}
