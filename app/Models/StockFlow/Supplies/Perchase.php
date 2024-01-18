<?php

namespace App\Models\StockFlow\Supplies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\StockFlow\Supplies\Perchase_Items;

class Perchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'vendor_name',
        'vendor_email',
        'vendor_contact_1',
        'vendor_contact_2',
        'vendor_address'
    ];

    public function perchase_Items(): HasMany
    {
        return $this->hasMany(Perchase_Items::class, 'perchase', 'id');
    }
}
