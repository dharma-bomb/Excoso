<?php

namespace App\Http\Controllers;

use App\Models\AddProduct;
use Illuminate\Http\Request;
use App\Models\ProductAdd;

class ProductsController extends Controller
{
    public function productList()
    {
        // Fetch all products from database
        $products = AddProduct::all();

        // Return view with products data
        return view('admin.listproduct', compact('products'));
        

    }
}
