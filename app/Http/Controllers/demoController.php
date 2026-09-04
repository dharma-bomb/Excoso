<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AddCat;
use App\Models\AddProduct;

class demoController extends Controller
{
    public function demoindex(){
        $categories = AddCat::all();
    $allProducts = [];

    foreach ($categories as $category) {
        $products = AddProduct::where('cat', $category->cat)->get();
        $allProducts[$category->cat] = $products;
    }

    $exploreall = AddProduct::all();

    return view('tabs', compact('allProducts','exploreall'));
    }
}
