<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    //Insert Product
    /*
    Sample Request Body
    {
        "name":"FED55",
        "vendor":"1",
        "connection_type":"PSTN",
        "description":"Pos Device",
    }

    Headers
    "Accept":"application/json"

    Sample URI
    http://192.168.8.185:8000/api/product/create

    */
    public function create(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'vendor' => 'required|exists:vendors,id',
            'connection_type' => 'in:PSTN,GPRS',
            'description' => 'string'
        ]);

        $product = Product::create([
            'name' => $fields['name'],
            'vendor' => $fields['vendor'],
            'connection_type' => $fields['connection_type'],
            'description' => $fields['description']
        ]);

        $response = [
            'status'=>201,
            'message'=>'Product Create Sucesss',
            'user' => $product,
        ];

        return response($response, 201);
    }

    //View Products
    /*
    Sample URI
    http://192.168.8.185:8000/api/product/view
    
    */
    public function retrive()
	{
        //$data['cart_items'] = CartItem::with('menu')->where('cart_id',$cart->id)->get();
        $product = Product::with('vendor')->get();
        $response = [
            'status'=>200,
            'product'=>$product
        ];
        
        return response($response, 200);
	}

    //Find Product
    /*
    Sample URI
    http://192.168.8.185:8000/api/product/view/1

    */
    public function find($id)
	{
        $product = Product::with('vendor')->withTrashed()->find($id);

        if($product){
            $response = [
                'status'=>200,
                'product'=>$product
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No product for provided product id'
            ];

            return response($response, 204);            
        }
	}

    //Find Products by Vendor
    /*
    Sample URI
    http://192.168.8.185:8000/api/product/view/byvendor/1

    */
    public function retrive_by_vendor($vendor)
	{
        $product = Product::with('vendor')->where('vendor',$vendor)->get();
        $response = [
            'status'=>200,
            'product'=>$product
        ];
        
        return response($response, 200);
	}

    //Update Controller
    /*
    Sample Request Body
    {
        "name":"JandJ",
        "email":"jandj@email.com",
        "contact_1":"0464646464",
        "contact_2":"4646533535",
        "address":"jandj, Landon."
    }

    Headers
    "Accept":"application/json"

    Sample URI
    http://192.168.8.185:8000/api/product/update/1

    */
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'name' => 'required|string|unique:products,name,'.$id,
            'vendor' => 'required|exists:vendors,id',
            'connection_type' => 'in:PSTN,GPRS',
            'description' => 'string'
        ]);

        $product = Product::find($id);

        $product->name=$fields['name'];
        $product->vendor=$fields['vendor'];
        $product->connection_type=$fields['connection_type'];
        $product->description=$fields['description'];

        $product->save();

        $product = Product::find($id);

        $response=[
            'status'=>200,
            'message'=>'Product Updated Sucesss',
            'product'=>$product
        ];

        return response($response, 200);
    }

    //Delete product
    /*
    Sample URI
    http://192.168.8.185:8000/api/product/delete/1

    */
    public function delete($id)
    {
        $product = Product::find($id);

        if($product){
            $product->delete();

            $response = [
                'status'=>200,
                'message'=>'Product delete sucesss',
                'user' => $product
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No product for provided product id'
            ];

            return response($response, 204);            
        }
    }
}
