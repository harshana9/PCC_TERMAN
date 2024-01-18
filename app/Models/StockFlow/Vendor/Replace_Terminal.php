<?php

namespace App\Models\StockFlow\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replace_Terminal extends Model
{
    use HasFactory;

    protected $fillable = [
        'replace',
        'date',
        'merchant',
        'tid',
        'mid',
        'city',
        'remark',

        'old_product',
        'serial_no_old',
        'old_connection_type',
        'old_machine_condition',
        
        'new_product',
        'serial_no_new',
        'new_machine_condition',
        'new_connection_type'
    ];
}
