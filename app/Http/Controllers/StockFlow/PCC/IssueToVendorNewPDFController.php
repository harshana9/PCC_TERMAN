<?php

namespace App\Http\Controllers\StockFlow\PCC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\StockFlow\PCC\IssueToVendorNew;
use App\Models\StockFlow\PCC\IssueToVendorNew_Items;

class IssueToVendorNewPDFController extends Controller
{
   /*
      Generate Purchase Note PDF
      http://127.0.0.1:8000/api/pcc/issuetovendor/newterminal/pdf/id
   */
  
   public function generatePDF($id)

   {
        $stock_issue_notes = IssueToVendorNew::with('IssueToVendorNew_Items')->find($id)->toArray();

       $data = [
          'title' => 'Issue to Vendor for Deployment',
          'dataset' => $stock_issue_notes
       ];

       $pdf = PDF::loadView('issue_from_pcc_to_vendor_new', $data);

       return $pdf->download('IssueToVendorForDeployment.pdf');
   }
}
