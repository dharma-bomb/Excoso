<?php

namespace App\Http\Controllers;

use App\Models\AddCat;
use App\Models\AddProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexControll extends Controller
{
    public function indexdata()
    {


        $categories = AddCat::all();
        $allProducts = [];

        foreach ($categories as $category) {
            $products = AddProduct::where('cat', $category->cat)->get();
            $allProducts[$category->cat] = $products;
        }

        $exploreall = AddProduct::all();

        return view('index', compact('allProducts', 'exploreall'));
    }




    // return view("index", compact('CatDet','prodimg'));

    // $data = AddCat::join('add_products', 'add_cats.cat', '=', 'add_products.cat')
    // ->select(
    //     'add_cats.cat as category_name',
    //     'add_products.images as product_images',
    //     'add_products.Productname as product_name',
    //     DB::raw('COUNT(add_products.id) as product_count') // Assuming `id` is the primary key in `add_products`
    // )
    // ->groupBy('add_cats.cat', 'add_products.images', 'add_products.Productname')
    // ->get();


    //     $data = AddCat::join('add_products', 'add_cats.cat', '=', 'add_products.cat')
    // ->select(
    //     'add_cats.cat as category_name',
    //     'add_products.images as product_images',
    //     'add_products.productname as product_name'
    // )
    // ->get();











    // $data->transform(function ($item) {
    //     $item->product_images = json_decode($item->product_images, true); // Decode JSON string into associative array
    //     return $item;
    // });

    // $CatDet = AddCat::all();
    // $categoriesWithProducts = [];

    // foreach ($CatDet as $category) {
    //     $products = AddProduct::where('cat', $category->cat)->get();
    //     $categoriesWithProducts[] = [
    //         'category' => $category,
    //         'products' => $products,
    //     ];
    // }




    public function show($slug)
    {
        $category = AddCat::where('slug', $slug)->firstOrFail();
        // You can fetch related products or other data as needed
        return view('category.show', compact('category'));
    }

    public function fetchData(Request $request)
    {
        $category = $request->input('category');

        // // Fetch data based on category name
        // $curosal = AddProduct::where('cat', $category)->get(); // Example query, adjust as per your actual data structure

        // // Return view or JSON response based on your needs
        // return view('index', compact('curosal')); // Assuming 'partials.product-list' is a Blade view


        $products = AddProduct::where('cat', $category)->get(); // Example: Retrieve all products from database

        return view('products', compact('products'));
    }
}
