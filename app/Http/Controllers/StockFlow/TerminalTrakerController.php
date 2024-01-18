<?php

namespace App\Http\Controllers\StockFlow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terminal;

class TerminalTrakerController extends Controller
{
    /*
        Retrive data with pagination and search key
        http://192.168.57.73:8000/api/terminal/search/{page_size}/{keyword}
    */

    public function retrive($page_size,$keyword)
	{
        $terminals = Terminal::
            where(function ($query) use($keyword) {
                $query
                    ->where('vendor_name', 'like', $keyword . '%')
                    ->orWhere('product', $keyword)
                    ->orWhere('connection_type', $keyword)
                    ->orWhere('merchant', 'like', '%' . $keyword . '%')
                    ->orWhere('tid', 'like', '%' . $keyword . '%')
                    ->orWhere('mid', 'like', '%' . $keyword . '%')
                    ->orWhere('city', 'like', '%' . $keyword . '%')
                    ->orWhere('serial_no', 'like', '%' . $keyword . '%')
                    ->orWhere('condition', $keyword);
              })
            ->paginate($page_size);
        $response = [
            'status'=>200,
            'terminals'=>$terminals
        ];

        return response($response, 200);
	}

    /*
        Retrive all data with pagination
        http://192.168.57.73:8000/api/terminal/search/result_per_page
    */

    public function retrive_all($page_size)
	{
        $terminals = Terminal::
            where('id', '>', 0)
            ->paginate($page_size);
        $response = [
            'status'=>200,
            'terminals'=>$terminals
        ];

        return response($response, 200);
	}

    /*
        Retrive single item
        http://192.168.57.73:8000/api/terminal/view/id
    */
    public function find($id)
	{
        $terminals = Terminal::find($id);

        if($terminals){
            $response = [
                'status'=>200,
                'terminals'=>$terminals
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No Terminal for provided id'
            ];

            return response($response, 204);            
        }
	}

    //TID history
    /*
        Retrive single item
        http://192.168.57.73:8000/api/terminal/history/tid/12454
    */
    public function tid_history($tid)
	{
        $terminals = Terminal::
            where('tid', $tid)
            ->orderBy('created_at', 'DESC')
            ->withTrashed()
            ->get();
        $response = [
            'status'=>200,
            'terminals'=>$terminals
        ];

        return response($response, 200);
	}

    //SN history
    /*
        Retrive single item
        http://192.168.57.73:8000/api/terminal/history/sn/1TSD2454
    */
    public function sn_history($sn)
	{
        $terminals = Terminal::
            where('serial_no', $sn)
            ->orderBy('created_at', 'DESC')
            ->withTrashed()
            ->get();
        $response = [
            'status'=>200,
            'terminals'=>$terminals
        ];

        return response($response, 200);
	}

    //SN history
    /*
        Retrive single item
        http://192.168.8.185:8000/api/terminal/deployed_cities
    */
    public function city_list()
	{
        $city_list = Terminal::
            select('city')
            ->orderBy('city', 'ASC')
            ->withTrashed()
            ->groupBy('city')
            ->get();
        $response = [
            'status'=>200,
            'city'=>$city_list
        ];
        return response($response, 200);
	}

}
