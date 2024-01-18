<?php

namespace App\Models\StockFlow\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\StockFlow\Vendor\Replace_Terminal;

class Replace extends Model
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

    public function replace_Terminal(): HasMany
    {
        return $this->hasMany(Replace_Terminal::class, 'replace', 'id');
    }
}
