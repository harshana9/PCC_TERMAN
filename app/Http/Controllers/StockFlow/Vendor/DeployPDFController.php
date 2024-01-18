<?php

namespace App\Http\Controllers\StockFlow\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\StockFlow\Vendor\Deploy;
use App\Models\StockFlow\Vendor\Deploy_Terminal;

class DeployPDFController extends Controller
{
    /*
      Generate Purchase Note PDF
      http://127.0.0.1:8000/api/vendor/issue/pdf/8
   */
  
   public function generatePDF($id)

   {
      $deployment_notes = Deploy::with('deploy_Terminal')->find($id)->toArray();

       $data = [
          'title' => 'Terminal Deployment Note',
          'dataset' => $deployment_notes
       ];

       $pdf = PDF::loadView('deploy_terminal', $data);

       return $pdf->download('DeployTerminal.pdf');
   }
}