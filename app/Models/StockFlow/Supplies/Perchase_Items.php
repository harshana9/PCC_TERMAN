<?php

namespace App\Models\StockFlow\Supplies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perchase_Items extends Model
{
    use HasFactory;

    protected $fillable = [
        'perchase',
        'product_name',
        'connection_type',
        'description',
        'serial_first',
        'serial_last',
        'quantity'
    ];

}