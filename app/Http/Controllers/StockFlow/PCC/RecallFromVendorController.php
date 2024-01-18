<?php

namespace App\Http\Controllers\StockFlow\PCC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terminal;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\StockFlow\PCC\RecallFromVendor;
use App\Models\StockFlow\PCC\RecallFromVendor_Terminals;

class RecallFromVendorController extends Controller
{
    public function create(Request $request)
    {
        $fields = $request->validate([
            'date' => 'required|date',
            'vendor_id' => 'required|integer|exists:vendors,id',
            'terminals' => 'required|array',

            'terminals.*.serial_no' => 'required_without:terminals.*.tid|string|nullable',
            'terminals.*.tid' => 'required_without:terminals.*.serial_no|integer|nullable',
            'terminals.*.condition' => 'in:JUNKED,USED',
            'terminals.*.remark' => 'present|string|nullable',
        ]);

        //get vendor detilas for id
       $vendor = Vendor::find($fields['vendor_id']);

        //create recall note      
        $recall_note = RecallFromVendor::create([
            'date' => $fields['date'],
            'vendor_name' => $vendor['name'],
            'vendor_email' => $vendor['email'],
            'vendor_contact_1' => $vendor['contact_1'],
            'vendor_contact_2' => $vendor['contact_2'],
            'vendor_address' => $vendor['address']
        ]);

        //Add Terminals note
        foreach ($fields['terminals'] as $item)
        {
            //get deployed terminal
            $terminal = Terminal::where('tid', $item['tid'])->orWhere('serial_no', $item['serial_no'])->first();

            if(! $terminal){
                $response = [
                    'status'=>204,
                    'message'=>'No Terminal for provided TID/Serial'
                ];
        
                return response($response, 201);
            }

            //Add to Recall Note
            $recall_note_terminals = RecallFromVendor_Terminals::create([
                'recall' => $recall_note['id'],
                'product_name' => $terminal['product'],
                'connection_type' => $terminal['connection_type'],
                'serial_no' => $terminal['serial_no'],
                'tid' => $terminal['tid'],
                'mid' => $terminal['mid'],
                'merchant' => $terminal['merchant'],
                'city' => $terminal['city'],
                'condition' => $item['condition'],
                'remark' => $item['remark']
            ]);

            //Stock Update
            $product = Product::where('name', $terminal['product'])->first();

            if($item['condition']=="JUNKED"){
                $product->stock_junked = $product->stock_junked + 1;
            }
            elseif($item['condition']=="USED"){
                $product->stock_used_pcc = $product->stock_used_pcc + 1;
            }
            $product->stock_deployed = $product->stock_deployed - 1;

            $product->save();

            //Update Terminal Condition Before delete
            $terminal->remove_condition=$item['condition'];
            $terminal->save();

            //Remove old record from old terminals  table
            $terminal->delete();
        }

        $response = [
            'status'=>201,
            'message'=>'Product Recall Note Create Success.'
        ];

        return response($response, 201);
    }

    /*
        Retrive data with pagination and search key
        http://192.168.57.73:8000/pcc/recall/search/result_per_page/search_key
    */
    public function retrive($page_size,$keyword)
	{
        $recall_note = RecallFromVendor::with('recall_Terminal')
            ->where(function ($query) use($keyword) {
                $query->where('date', 'like', '%' . $keyword . '%')
                    ->orWhere('vendor_name', 'like', '%' . $keyword . '%')
                    ->orWhere('id', $keyword);
              })
            ->paginate($page_size);
        $response = [
            'status'=>200,
            'recall_note'=>$recall_note
        ];

        return response($response, 200);
	}

    /*
        Retrive all data with pagination
        http://192.168.57.73:8000/pcc/recall/search/result_per_page
    */
    public function retrive_all($page_size)
	{
        $recall_note = RecallFromVendor::with('recall_Terminal')
            ->where('id', '>', 0)
            ->paginate($page_size);
        $response = [
            'status'=>200,
            'recall_note'=>$recall_note
        ];

        return response($response, 200);
	}

    /*
        Retrive single item
        http://192.168.57.73:8000/pcc/issuetovendor/usedterminal/view/id
    */
    public function find($id)
	{
        $recall_note = RecallFromVendor::with('recall_Terminal')->find($id);

        if($recall_note){
            $response = [
                'status'=>200,
                'recall_note'=>$recall_note
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No Recall note for provided id'
            ];

            return response($response, 204);            
        }
	}
}