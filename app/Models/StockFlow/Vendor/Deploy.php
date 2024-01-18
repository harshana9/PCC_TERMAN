<?php

namespace App\Models\StockFlow\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\StockFlow\Vendor\Deploy_Terminal;

class Deploy extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',

        'vendor_name',
        'vendor_email',
        'vendor_contact_1',
        'vendor_contact_2',
        'vendor_address',

        'product',
        'product_connection_type'
    ];

    public function deploy_Terminal(): HasMany
    {
        return $this->hasMany(Deploy_Terminal::class, 'deploy', 'id');
    }
}
