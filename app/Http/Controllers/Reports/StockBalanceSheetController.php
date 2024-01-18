<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use PDF;
use Carbon\Carbon;

class StockBalanceSheetController extends Controller
{

    /*
        http://192.168.8.185:8000/api/reports/stockbalance/pdf
    */

    public function generatePDF() {
        $product = Product::with('vendor')->get()->toArray();

        $nowtime = Carbon::now();
        $nowtime->toDateTimeString();

       $data = [
          'title' => 'Stock Balance Sheet',
          'date' => $nowtime,
          'dataset' => $product
       ];

       //print_r($data);

       $pdf = PDF::loadView('stock_balance_sheet', $data)->setPaper('a4', 'landscape');

       return $pdf->download('StockBalance.pdf');
   }
}
