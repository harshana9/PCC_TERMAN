<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terminal;
use App\Models\Product;
use App\Models\Vendor;
use PDF;
use Carbon\Carbon;

class DeployedTerminalsReportController extends Controller
{
    /*
        http://192.168.8.185:8000/api/reports/deployed/pdf

        {
            "fil_vendor_id":"1",
            "fil_product_id":"1",
            "fil_city":"Horana",
            "fil_deploy_condition":"NEW",
            "fil_remove_condition":"JUNKED",
            "fil_date_from":"2023-12-14",
            "fil_date_to":"2023-12-28",
            "fil_deleted":ACTIVE,
            "order_by_1":"city",
            "order_by_2":"tid",
            "order_by_1_order":"ASC",
            "order_by_2_order":"DESC"
        }
    */


    /*
    Order by options

    vendor_name
    product
    connection_type
    merchant
    tid
    mid
    city
    serial_no
    remove_condition
    created_at
    condition
    */

    public function generatePDF(Request $request) {
        $fields = $request->validate([
            'fil_vendor_id' => 'integer|exists:vendors,id',
            'fil_product_id' => 'integer|exists:products,id',
            'fil_city' => 'string|nullable',
            'fil_deploy_condition' => 'in:NEW,USED|nullable',
            'fil_remove_condition' => 'in:USED,JUNKED|nullable',
            'fil_date_from' => 'date|nullable',
            'fil_date_to' => 'date|nullable',
            'fil_deleted' => 'in:ACTIVE,DELETED,BOTH|required',

            'order_by_1' => 'in:vendor_name,product,connection_type,merchant,tid,mid,city,serial_no,remove_condition,created_at,condition|nullable',
            'order_by_2' => 'in:vendor_name,product,connection_type,merchant,tid,mid,city,serial_no,remove_condition,created_at,condition|nullable',
            'order_by_1_order' => 'in:ASC,DESC|required',
            'order_by_2_order' => 'in:ASC,DESC|required'
        ]);

        $fil_product=null;
        $fil_vendor=null;

        if($fil_product){
            $fil_product = Product::find($fields['fil_product_id']);
        }
        if($fil_vendor){
            $fil_vendor = Vendor::find($fields['fil_vendor_id']);
        }

        $terminal = Terminal::query();

        if(isset($fil_vendor->name)){
            $terminal = $terminal->where('vendor_name',$fil_vendor->name);
        }
        if(isset($fil_product->name)){
            $terminal = $terminal->where('product',$fil_product->name);
        }
        if(isset($fields['fil_city'])){
            if(! is_null($fields['fil_city'])){
                $terminal = $terminal->where('city',$fields['fil_city']);
            }
        }
        if(isset($fields['fil_deploy_condition'])){
            if(! is_null($fields['fil_deploy_condition'])){
                $terminal = $terminal->where('condition',$fields['fil_deploy_condition']);
            }
        }
        if(isset($fields['fil_remove_condition'])){
            if(! is_null($fields['fil_remove_condition'])){
                $terminal = $terminal->where('remove_condition',$fields['fil_remove_condition']);
            }
        }
        if(isset($fields['fil_date_from'])){
            if(! is_null($fields['fil_date_from'])){
                $terminal = $terminal->where('created_at', "<=", $fields['fil_date_from']);
            }
        }
        if(isset($fields['fil_date_to'])){
            if(! is_null($fields['fil_date_to'])){
                $terminal = $terminal->where('created_at', ">=", $fields['fil_date_from']);
            }
        }

        if(isset($fields['order_by_1'])){
            if(! is_null($fields['order_by_1'])){
                $terminal = $terminal->orderBy($fields['order_by_1'], $fields['order_by_1_order']);
            }
        }

        if(isset($fields['order_by_2'])){
            if(! is_null($fields['order_by_2'])){
                $terminal = $terminal->orderBy($fields['order_by_2'], $fields['order_by_2_order']);
            }
        }

        if($fields['fil_deleted']=="DELETED"){
            $terminal = $terminal->onlyTrashed();
        }
        elseif($fields['fil_deleted']=="BOTH"){
            $terminal = $terminal->withTrashed();
        }
        
        $terminal = $terminal->get();

        $nowtime = Carbon::now();
        $nowtime->toDateTimeString();

       $data = [
          'title' => 'Deployed Terminals',
          'date' => $nowtime,
          'dataset' => $terminal
       ];

       //print_r($data);

       $pdf = PDF::loadView('deployed_terminal_report', $data)->setPaper('a4', 'landscape');

       return $pdf->download('DeployedTerminal.pdf');
   }
}
