<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AddProduct;

class ViewController extends Controller
{
    public function viewproducts(){

        $products = AddProduct::where('cat', 'Bags')->get();

        $allproducts = AddProduct::select('*')
        ->distinct('cat')

        ->get();


        return view('viewproduct', compact('products', 'allproducts'));


    }
}
