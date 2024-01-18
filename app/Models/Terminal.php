<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Terminal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'vendor_name',
        'vendor_email',
        'vendor_contact_1',
        'vendor_contact_2',
        'vendor_address',
        'product',
        'connection_type',
        'merchant',
        'tid',
        'mid',
        'city',
        'serial_no',
        'condition',
        'remove_condition'
    ];
}
