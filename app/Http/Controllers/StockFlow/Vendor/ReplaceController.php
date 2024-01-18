<?php

namespace App\Http\Controllers\StockFlow\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockFlow\Vendor\Replace;
use App\Models\StockFlow\Vendor\Replace_Terminal;
use App\Models\Vendor;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Terminal;

class ReplaceController extends Controller
{
    public function create(Request $request)
    {
        $fields = $request->validate([
            'date' => 'required|date',
            'vendor_id' => 'required|integer|exists:vendors,id',
            'terminals' => 'required|array',

            'terminals.*.tid' => 'required|integer',
            'terminals.*.date' => 'required|date',
            'terminals.*.remark' => 'present|string|nullable',
            'terminals.*.serial_no_new' => 'required|string',
            'terminals.*.new_machine_condition' => 'in:NEW,USED',
            'terminals.*.new_product_id' => 'required|integer|exists:products,id',
            'terminals.*.old_machine_condition' => 'in:JUNKED,USED'
        ]);

        //get vendor detilas for id
        $vendor = Vendor::find($fields['vendor_id']);

        //create deploy note detaild and vendor,product details
        $replace_note = Replace::create([
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
            //get product detilas for id
            $new_product = Product::find($item['new_product_id']);

            //find previous terminal record
            $old_terminal = Terminal::
                where('tid', $item['tid'])
                ->orderBy('updated_at','DESC')
                ->first();

            if(! $old_terminal){
                $response = [
                    'status'=>204,
                    'message'=>'No Terminal for provided Terminal ID'
                ];
        
                return response($response, 201);
            }

            $old_product = Product::where('name', $old_terminal['product'])->first();


            //Add to Replace Note
            $replace_note_terminals = Replace_Terminal::create([
                'replace' => $replace_note['id'],
                'date' => $item['date'],
                'merchant' => $old_terminal['merchant'],
                'tid' => $old_terminal['tid'],
                'mid' => $old_terminal['mid'],
                'city' => $old_terminal['city'],
                'remark' => $item['remark'],

                'old_product' => $old_terminal['product'],
                'serial_no_old' => $old_terminal['serial_no'],
                'old_connection_type' => $old_terminal['connection_type'],
                'old_machine_condition' => $item['old_machine_condition'],
                
                'new_product' => $new_product['name'],
                'serial_no_new' => $item['serial_no_new'],
                'new_machine_condition' => $item['new_machine_condition'],
                'new_connection_type' => $new_product['connection_type']
            ]);

            //Stock Update -for deployment of new
            if($item['new_machine_condition']=="NEW"){
                $new_product->stock_new_vendor = $new_product->stock_new_vendor - 1;
            }
            elseif($item['new_machine_condition']=="USED"){
                $new_product->stock_used_vendor = $new_product->stock_used_vendor - 1;
            }
            $new_product->save();

            //Stock Update -for removal of old
            if($item['old_machine_condition']=="JUNKED"){
                $old_product->stock_junked = $old_product->stock_junked + 1;
            }
            elseif($item['old_machine_condition']=="USED"){
                $old_product->stock_used_vendor = $old_product->stock_used_vendor + 1;
            }
            $old_product->save();

            //Update Condition at removal of old terminal
            $old_terminal->remove_condition = $item["old_machine_condition"];
            $old_terminal->save();

            //Remove old record from old terminals  table
            $old_terminal->delete();

            //Add to all terminals table
            $terminal = Terminal::create([
                'date' => $item['date'],
                'vendor_name' => $vendor['name'],
                'vendor_email' => $vendor['email'],
                'vendor_contact_1' => $vendor['contact_1'],
                'vendor_contact_2' => $vendor['contact_2'],
                'vendor_address' => $vendor['address'],
                'product' => $new_product['name'],
                'connection_type' => $new_product['connection_type'],
                'merchant' => $old_terminal['merchant'],
                'tid' => $old_terminal['tid'],
                'mid' => $old_terminal['mid'],
                'city' => $old_terminal['city'],
                'serial_no' => $item['serial_no_new'],
                'condition' => $item['new_machine_condition']
            ]);
        }

        $response = [
            'status'=>201,
            'message'=>'Product Replace Note Create Success.'
        ];

        return response($response, 201);
    }

     /*
        Retrive data with pagination and search key
        http://192.168.8.185:8000/api/vendor/replace/search/10/keyword
    */

    public function retrive($page_size,$keyword)
	{
        $replace_note = Replace::with('replace_Terminal')
            ->join('replace__terminals', 'replaces.id', '=', 'replace__terminals.replace')
            ->where(function ($query) use($keyword) {
                $query->where('replace__terminals.date', 'like', '%' . $keyword . '%')
                    ->orWhere('replaces.date', 'like', '%' . $keyword . '%')
                    ->orWhere('vendor_name', 'like', '%' . $keyword . '%')
                    ->orWhere('merchant', 'like', '%' . $keyword . '%')
                    ->orWhere('tid', 'like', '%' . $keyword . '%')
                    ->orWhere('mid', 'like', '%' . $keyword . '%')
                    ->orWhere('city', 'like', '%' . $keyword . '%')
                    ->orWhere('serial_no_old', 'like', '%' . $keyword . '%')
                    ->orWhere('serial_no_new', 'like', '%' . $keyword . '%');
              })
            ->select('replaces.*', 'replace__terminals.date as replace_date')
            /*->toSql();*/
            ->paginate($page_size);

        $response = [
            'status'=>200,
            'replace_notes'=>$replace_note
        ];

        return response($response, 200);
	}

    /*
        Retrive all data with pagination
        http://192.168.8.185:8000/api/vendor/replace/search/10
    */

    public function retrive_all($page_size)
	{
        $replace_note = Replace::with('replace_Terminal')
            ->where('id', '>', 0)
            ->paginate($page_size);
        $response = [
            'status'=>200,
            'replace_notes'=>$replace_note
        ];

        return response($response, 200);
	}

    /*
        Retrive single item
        http://192.168.8.185:8000/api/vendor/replace/view/1
    */
    public function find($id)
	{
        $replace_note = Replace::with('replace_Terminal')->find($id);

        if($replace_note){
            $response = [
                'status'=>200,
                'replace_notes'=>$replace_note
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No Replace note for provided id'
            ];

            return response($response, 204);            
        }
	}
}