<?php

namespace App\Http\Controllers\StockFlow\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\StockFlow\Vendor\Replace;
use App\Models\StockFlow\Vendor\Replace_Terminal;

class ReplacePDFController extends Controller
{
    /*
      Generate Purchase Note PDF
      http://127.0.0.1:8000/api/supplies/issue/pdf/8
   */
  
   public function generatePDF($id)

   {
      $replacement_notes = Replace::with('replace_Terminal')->find($id)->toArray();

       $data = [
          'title' => 'Terminal Replacement Note',
          'dataset' => $replacement_notes
       ];

       $pdf = PDF::loadView('replace_terminal', $data);

       return $pdf->download('ReplaceTerminal.pdf');
   }
}