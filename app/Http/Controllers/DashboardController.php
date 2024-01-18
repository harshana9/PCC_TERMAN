<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Terminal;
use App\Models\Product;

class DashboardController extends Controller
{
    /*
    Sample URI
    http://192.168.8.185:8000/api/dashboard

    */
    public function terminal_status()
	{
        $number_of_terminals = Terminal::get()->count();
        $number_of_cities = Terminal::select('city')->groupBy('city')->get()->count();
        $number_of_merchants = Terminal::select('mid')->groupBy('mid')->get()->count();
        $product = Product::with('vendor')->get();

        $response = [
            'status'=>200,
            'total_terminals'=>$number_of_terminals,
            'total_cities'=>$number_of_cities,
            'total_merchnats'=>$number_of_merchants,
            'stock'=>$product
        ];

        return response($response, 200);

	}
}
