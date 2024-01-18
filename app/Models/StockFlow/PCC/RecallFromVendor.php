<?php

namespace App\Models\StockFlow\PCC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StockFlow\PCC\RecallFromVendor_Terminals;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecallFromVendor extends Model
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

    public function recall_Terminal(): HasMany
    {
        return $this->hasMany(RecallFromVendor_Terminals::class, 'recall', 'id');
    }
}
