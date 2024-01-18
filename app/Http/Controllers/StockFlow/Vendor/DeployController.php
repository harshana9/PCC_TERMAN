<?php

namespace App\Http\Controllers\StockFlow\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockFlow\Vendor\Deploy;
use App\Models\StockFlow\Vendor\Deploy_Terminal;
use App\Models\Vendor;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Terminal;

class DeployController extends Controller
{
    public function create(Request $request)
    {
        $fields = $request->validate([
            'date' => 'required|date',
            'vendor_id' => 'required|integer|exists:vendors,id',
            'product_id' => 'required|integer|exists:products,id',
            'terminals' => 'required|array',

            'terminals.*.date' => 'required|date',
            'terminals.*.merchant' => 'required|string',
            'terminals.*.tid' => 'required|integer',
            'terminals.*.mid' => 'required|integer',
            'terminals.*.city' => 'required|string',
            'terminals.*.serial_no' => 'required|string',
            'terminals.*.remark' => 'present|string|nullable',
            'terminals.*.condition' => 'in:NEW,USED'
        ]);

        //get vendor detilas for id
        $vendor = Vendor::find($fields['vendor_id']);

        //get product detilas for id
        $product = Product::find($fields['product_id']);

        //create deploy note detaild and vendor,product details
        $deploy_note = Deploy::create([
            'date' => $fields['date'],
            'vendor_name' => $vendor['name'],
            'vendor_email' => $vendor['email'],
            'vendor_contact_1' => $vendor['contact_1'],
            'vendor_contact_2' => $vendor['contact_2'],
            'vendor_address' => $vendor['address'],
            'product' => $product['name'],
            'connection_type' => $product['connection_type']
        ]);


        //Add Terminals note
        foreach ($fields['terminals'] as $item)
        {
            //Add to Deploy Note
            $deploy_note_terminals = Deploy_Terminal::create([
                'deploy' => $deploy_note['id'],
                'date' => $item['date'],
                'merchant' => $item['merchant'],
                'tid' => $item['tid'],
                'mid' => $item['mid'],
                'city' => $item['city'],
                'serial_no' => $item['serial_no'],
                'condition' => $item['condition'],
                'remark' => $item['remark']
            ]);

            //Stock Update
            $product->stock_new_vendor = $product->stock_new_vendor - 1;
            $product->stock_deployed = $product->stock_deployed + 1;
            $product->save();

            //Add to all terminals table
            $terminal = Terminal::create([
                'date' => $fields['date'],
                'vendor_name' => $vendor['name'],
                'vendor_email' => $vendor['email'],
                'vendor_contact_1' => $vendor['contact_1'],
                'vendor_contact_2' => $vendor['contact_2'],
                'vendor_address' => $vendor['address'],
                'product' => $product['name'],
                'connection_type' => $product['connection_type'],
                'merchant' => $item['merchant'],
                'tid' => $item['tid'],
                'mid' => $item['mid'],
                'city' => $item['city'],
                'serial_no' => $item['serial_no'],
                'condition' => $item['condition']
            ]);
        }

        $response = [
            'status'=>201,
            'message'=>'Product Deploy Note Create Success.'
        ];

        return response($response, 201);
    }

    /*
        Retrive data with pagination and search key
        http://192.168.57.73:8000/api/
    */

    public function retrive($page_size,$keyword)
	{
        $deploy_note = Deploy::with('deploy_Terminal')
            ->join('deploy__terminals', 'deploys.id', '=', 'deploy__terminals.deploy')
            ->where(function ($query) use($keyword) {
                $query->where('deploy__terminals.date', 'like', '%' . $keyword . '%')
                    ->where('deploys.date', 'like', '%' . $keyword . '%')
                    ->orWhere('vendor_name', 'like', '%' . $keyword . '%')
                    ->orWhere('merchant', 'like', '%' . $keyword . '%')
                    ->orWhere('tid', 'like', '%' . $keyword . '%')
                    ->orWhere('mid', 'like', '%' . $keyword . '%')
                    ->orWhere('city', 'like', '%' . $keyword . '%')
                    ->orWhere('serial_no', 'like', '%' . $keyword . '%');
              })
            ->select('deploys.*', 
                'deploy__terminals.date as deploy_date')
            ->paginate($page_size);
            /*->toSql();*/
        //$deploy_note=$keyword;
        $response = [
            'status'=>200,
            'deploy_notes'=>$deploy_note
        ];

        return response($response, 200);
	}

    /*
        Retrive all data with pagination
        http://192.168.57.73:8000/api/supplies/purchase/view/result_per_page
    */

    public function retrive_all($page_size)
	{
        $deploy_note = Deploy::with('deploy_Terminal')
            ->where('id', '>', 0)
            ->paginate($page_size);
        $response = [
            'status'=>200,
            'deploy_notes'=>$deploy_note
        ];

        return response($response, 200);
	}

    /*
        Retrive single item
        http://192.168.57.73:8000/api/supplies/purchase/view/id
    */
    public function find($id)
	{
        $deploy_note = Deploy::with('deploy_Terminal')->find($id);

        if($deploy_note){
            $response = [
                'status'=>200,
                'deploy_notes'=>$deploy_note
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No Deploy note for provided id'
            ];

            return response($response, 204);            
        }
	}
}
