<?php

namespace App\Http\Controllers\StockFlow\PCC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\StockFlow\PCC\IssueToVendorUsed;
use App\Models\StockFlow\PCC\IssueToVendorUsed_Items;

class IssueToVendorUsedPDFController extends Controller
{
    /*
      Generate Purchase Note PDF
      http://127.0.0.1:8000/api/pcc/issuetovendor/usedterminal/pdf/id
   */
  
   public function generatePDF($id)

   {
        $stock_issue_notes = IssueToVendorUsed::with('IssueToVendorUsed_Items')->find($id)->toArray();

       $data = [
          'title' => 'Issue to Vendor for Deployment (Used Terminals)',
          'dataset' => $stock_issue_notes
       ];

       $pdf = PDF::loadView('issue_from_pcc_to_vendor_used', $data);

       return $pdf->download('IssueToVendorForDeployment_UsedTerminals.pdf');
   }
}