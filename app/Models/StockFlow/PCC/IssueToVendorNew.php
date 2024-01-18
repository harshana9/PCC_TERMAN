<?php

namespace App\Models\StockFlow\PCC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\StockFlow\PCC\IssueToVendorNew_Items;

class IssueToVendorNew extends Model
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

    public function issueToVendorNew_Items(): HasMany
    {
        return $this->hasMany(IssueToVendorNew_Items::class, 'issue_to_vendor_new', 'id');
    }
}
