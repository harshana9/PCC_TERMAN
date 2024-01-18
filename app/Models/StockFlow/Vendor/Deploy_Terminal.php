<?php

namespace App\Models\StockFlow\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deploy_Terminal extends Model
{
    use HasFactory;

    //Date	Merchant	TID	MID	City	Serial No.
    protected $fillable = [
        'deploy',
        
        'date',
        'merchant',
        'tid',
        'mid',
        'city',
        'serial_no',
        'condition',
        'remark'
    ];
}
