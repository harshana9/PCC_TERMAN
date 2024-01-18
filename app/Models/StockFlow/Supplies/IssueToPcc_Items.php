<?php

namespace App\Models\StockFlow\Supplies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueToPcc_Items extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_to_pcc',
        'product_name',
        'connection_type',
        'description',
        'serial_first',
        'serial_last',
        'quantity'
    ];
}
