<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Vendor;

class VendorController extends Controller
{
    //Insert Vendor
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
    http://192.168.8.185:8000/api/vendor/create

    */
    public function create(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'string|unique:vendors,email',
            'contact_1' => 'string',
            'contact_2' => 'string',
            'address' => 'string'
        ]);

        $vendor = Vendor::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'contact_1' => $fields['contact_1'],
            'contact_2' => $fields['contact_2'],
            'address' => $fields['address']
        ]);

        $response = [
            'status'=>201,
            'message'=>'Vendor Create Sucesss',
            'user' => $vendor,
        ];

        return response($response, 201);
    }

    //View Vendors
    /*
    Sample URI
    http://192.168.8.185:8000/api/vendor/view
    
    */
    public function retrive()
	{
        $vendor = Vendor::all();
        $response = [
            'status'=>200,
            'vendor'=>$vendor
        ];
        
        return response($response, 200);
	}

    //Find Vendor
    /*
    Sample URI
    http://192.168.8.185:8000/api/vendor/view/1

    */
    public function find($id)
	{
        $vendor = Vendor::withTrashed()->find($id);

        if($vendor){
            $response = [
                'status'=>200,
                'vendor'=>$vendor
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No vendor for provided vendor id'
            ];

            return response($response, 204);            
        }
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
    http://192.168.8.185:8000/api/vendor/update/1

    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'string|unique:vendors,email,'.$id,
            'contact_1' => 'string',
            'contact_2' => 'string',
            'address' => 'string'
        ]);

        $vendor = Vendor::find($id);

        $vendor->name=$request->name;
        $vendor->email=$request->email;
        $vendor->contact_1=$request->contact_1;
        $vendor->contact_2=$request->contact_2;
        $vendor->address=$request->address;

        $vendor->save();

        $vendor = Vendor::find($id);

        $response=[
            'status'=>200,
            'message'=>'Vendor Updated Sucesss',
            'vendor'=>$vendor
        ];

        return response($response, 200);
    }

    //Delete vendor
    /*
    Sample URI
    http://192.168.8.185:8000/api/vendor/delete/1

    */
    public function delete($id)
    {
        $vendor = Vendor::find($id);

        if($vendor){
            $vendor->delete();

            $response = [
                'status'=>200,
                'message'=>'Vendor delete sucesss',
                'user' => $vendor
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No vendor for provided vendor id'
            ];

            return response($response, 204);            
        }
    }

}
