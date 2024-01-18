<?php

namespace App\Models\StockFlow\PCC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecallFromVendor_Terminals extends Model
{
    use HasFactory;

    protected $fillable = [
        'recall',
        'product_name',
        'connection_type',
        'serial_no',
        'tid',
        'mid',
        'merchant',
        'city',
        'condition',
        'remark'
    ];
}