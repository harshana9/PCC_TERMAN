<?php

namespace App\Http\Controllers\StockFlow\PCC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\StockFlow\PCC\RecallFromVendor;
use App\Models\StockFlow\PCC\RecallFromVendor_Terminals;

class RecallFromVendorPDFController extends Controller
{
    /*
      Generate Purchase Note PDF
      http://192.168.8.185:8000/api/pcc/recall/pdf/5
   */
  
   public function generatePDF($id)
   {
        $recall_notes = RecallFromVendor::with('recall_Terminal')->find($id)->toArray();

        $data = [
            'title' => 'Recall from Merchant Note',
            'dataset' => $recall_notes
        ];

        $pdf = PDF::loadView('recall_from_merchant_note', $data);

        return $pdf->download('RecallFromMerchnat.pdf');
   }
}
