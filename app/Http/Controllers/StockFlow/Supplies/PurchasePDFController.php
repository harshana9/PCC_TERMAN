<?php

namespace App\Http\Controllers\StockFlow\Supplies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\StockFlow\Supplies\Perchase;
use App\Models\StockFlow\Supplies\Perchase_Items;

class PurchasePDFController extends Controller
{

   /*
      Generate Purchase Note PDF
      http://127.0.0.1:8000/api/supplies/purchase/pdf/8
   */
  
     public function generatePDF($id)

     {
        $stock_perchase_notes = Perchase::with('perchase_Items')->find($id)->toArray();

         $data = [
            'title' => 'Purchase Note',
            'dataset' => $stock_perchase_notes
         ];

         $pdf = PDF::loadView('purchase_note', $data);

         return $pdf->download('PurchaseNote.pdf');
     }
}
