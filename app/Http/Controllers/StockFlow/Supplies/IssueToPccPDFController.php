<?php

namespace App\Http\Controllers\StockFlow\Supplies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\StockFlow\Supplies\IssueToPcc;
use App\Models\StockFlow\Supplies\IssueToPcc_Items;

class IssueToPccPDFController extends Controller
{

   /*
      Generate Purchase Note PDF
      http://127.0.0.1:8000/api/supplies/issue/pdf/8
   */
  
     public function generatePDF($id)

     {
        $stock_issue_notes = IssueToPcc::with('issueToPCC_Items')->find($id)->toArray();

         $data = [
            'title' => 'Issue to PCC Note',
            'dataset' => $stock_issue_notes
         ];

         $pdf = PDF::loadView('issue_note_to_pcc', $data);

         return $pdf->download('IssueToPcc.pdf');
     }
}
