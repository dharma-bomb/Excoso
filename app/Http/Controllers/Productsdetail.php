<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductAdd;

class Productsdetail extends Controller
{
    public function productList()
    {
        // Fetch all products from database
        $products = ProductAdd::all();

        // Return view with products data
        return view('admin.listproduct', ['products' => $products]);
    }
}
