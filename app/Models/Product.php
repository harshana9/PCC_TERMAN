<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Vendor;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'vendor',
        'connection_type',
        'description',

        'stock_new_vendor',
        'stock_new_supplies',
        'stock_new_pcc',
        'stock_used_vendor',
        'stock_used_supplies',
        'stock_used_pcc',
        'stock_deployed',
        'stock_junked'
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor', 'id');
    }
}
