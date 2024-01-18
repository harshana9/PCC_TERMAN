<?php

namespace App\Http\Controllers\StockFlow\Supplies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockFlow\Supplies\IssueToPcc;
use App\Models\StockFlow\Supplies\IssueToPcc_Items;
use App\Models\Vendor;
use App\Models\Product;

class IssueToPccController extends Controller
{
    public function create(Request $request)
    {
        $fields = $request->validate([
            'date' => 'required|date',
            'vendor_id' => 'required|integer|exists:vendors,id',
            'items' => 'required|array',

            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.description' => 'string|present|nullable',
            'items.*.serial_first' => 'required|string',
            'items.*.serial_last' => 'required|string',
            'items.*.quantity' => 'required|integer'
        ]);



        //get vendor detilas for id
        $vendor = Vendor::find($fields['vendor_id']);

        //create purchase note with grn detaild and vendor details
        $issue_note_to_pcc = IssueToPcc::create([
            'date' => $fields['date'],
            'vendor_name' => $vendor['name'],
            'vendor_email' => $vendor['email'],
            'vendor_contact_1' => $vendor['contact_1'],
            'vendor_contact_2' => $vendor['contact_2'],
            'vendor_address' => $vendor['address']
        ]);

        //Add items to Perchase note
        foreach ($fields['items'] as $item)
        {
            //find product from product id
            $product = Product::find($item['product_id']);

            //Add to Perchase Note
            $stock_issue_note_to_pcc_items = IssueToPcc_Items::create([
                'issue_to_pcc' => $issue_note_to_pcc['id'],
                'product_name' => $product['name'],
                'connection_type' => $product['connection_type'],
                'description' => $item['description'],
                'serial_first' => $item['serial_first'],
                'serial_last' => $item['serial_last'],
                'quantity' => $item['quantity']
            ]);

            //Stock Update
            $product->stock_new_supplies = $product->stock_new_supplies - $item['quantity'];
            $product->stock_new_pcc = $product->stock_new_pcc + $item['quantity'];
            $product->save();
        }

        $response = [
            'status'=>201,
            'message'=>'Issue Note to PCC Create Sucesss'
        ];

        return response($response, 201);
    }

    /*
        Retrive data with pagination and search key
        http://192.168.57.73:8000/api/supplies/issuetopcc/view/result_per_page/search_key
    */

    public function retrive($page_size,$keyword)
	{
        //$data['cart_items'] = CartItem::with('menu')->where('cart_id',$cart->id)->get();
        $stock_issue_notes_to_pcc = IssueToPcc::with('issueToPCC_Items')
            ->where(function ($query) use($keyword) {
                $query->where('date', 'like', '%' . $keyword . '%')
                    ->orWhere('vendor_name', 'like', '%' . $keyword . '%')
                    ->orWhere('id', $keyword);
              })
            ->paginate($page_size);
        $response = [
            'status'=>200,
            'product'=>$stock_issue_notes_to_pcc
        ];

        return response($response, 200);
	}

    /*
        Retrive all data with pagination
        http://192.168.57.73:8000/api/supplies/issuetopcc/view/result_per_page
    */

    public function retrive_all($page_size)
	{
        //$data['cart_items'] = CartItem::with('menu')->where('cart_id',$cart->id)->get();
        $stock_issue_notes_to_pcc = IssueToPcc::with('issueToPCC_Items')
            ->where('id', '>', 0)
            ->paginate($page_size);
        $response = [
            'status'=>200,
            'product'=>$stock_issue_notes_to_pcc
        ];

        return response($response, 200);
	}

    /*
        Retrive single item
        http://192.168.57.73:8000/api/supplies/issuetopcc/view/id
    */
    public function find($id)
	{
        $stock_issue_notes_to_pcc = IssueToPcc::with('issueToPCC_Items')->find($id);

        if($stock_issue_notes_to_pcc){
            $response = [
                'status'=>200,
                'issue_to_pcc_note'=>$stock_issue_notes_to_pcc
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No Issue to PCC note for provided id'
            ];

            return response($response, 204);            
        }
	}
}