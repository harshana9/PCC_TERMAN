<?php

namespace App\Models\StockFlow\PCC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\StockFlow\PCC\IssueToVendorUsed_Items;

class IssueToVendorUsed extends Model
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

    public function issueToVendorUsed_Items(): HasMany
    {
        return $this->hasMany(IssueToVendorUsed_Items::class, 'issue_to_vendor_used', 'id');
    }
}