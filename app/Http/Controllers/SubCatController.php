<?php

namespace App\Http\Controllers;

use App\Models\AddSubCat;
use App\Models\AddCat;
use Illuminate\Http\Request;


class SubCatController extends Controller
{
    public function subcatadd(Request $request)
    {
        $cat = $request->input("Category");
        $subcat = $request->input("subcat");
        // Create a new instance of AddSubCat
        $catadd = new AddSubCat;
        // Assign the validated data to the model
        $catadd->cat = $cat;
        $catadd->subcat = $subcat;
        // Save the model to the database
        $catadd->save();
        // Redirect to the admin dashboard or another appropriate route
        return redirect()->route('admin.addsubcat');
    }


    public function listsubcat()
    {
        $categories = AddCat::select('*')->get('cat');
        // Pass the categories and subcategories to the view
        return view('admin.addsubcat', ['categories' => $categories]);
    }

    public function listingsubcat(Request $request)
    {
        $categoryId = $request->input('category_id');
        // Fetch subcategories based on the selected category id
        $subcategories = AddSubCat::where('cat', $categoryId)->get();
        // Return subcategories as JSON
        return response()->json(['subcategories' => $subcategories]);
    }

}
