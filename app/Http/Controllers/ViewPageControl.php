<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AddProduct;

class ViewPageControl extends Controller
{
    // public function index()
    // {
    //     // Example: Fetch all products grouped by category
    //     $allProducts = AddProduct::all()->groupBy('category'); // Adjust with your product model and category field

    //     return view('viewproduct', compact('allProducts'));
    // }

    public function viewProduct($category)
    {
        $products = AddProduct::where('cat', $category)->get(); // Adjust as per your product model and category field

        $allproducts = AddProduct::select('*')
        ->distinct('cat')

        ->get();

        return view('viewproduct', [
            'products' => $products,
            'category' => $category,
            'allproducts'=>$allproducts,
        ]);

        // return view('viewproduct', compact('products', 'allproducts'));
    }
}
