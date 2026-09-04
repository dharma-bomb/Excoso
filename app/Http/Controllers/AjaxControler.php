<?php

namespace App\Http\Controllers;

use App\Models\AddCat;
use Illuminate\Http\Request;
use App\Models\AddProduct;
use App\Models\Ajaxdata;

class AjaxControler extends Controller
{
    public function fetchProducts(Request $request)
    {
        $category = $request->input('category');
        $products = AddProduct::where('cat', $category)->get(); // Adjust 'cat' as per your column name

        // Return a Blade view with the fetched products
        return view('products', compact('products'));
    }

    public function formsubmit(Request $request)
    {
        // Validate incoming request data
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:ajaxdatas,email',
            'mobile' => 'required|string|max:20',
        ]);

        // Create a new instance of Ajaxdata model
        $newdata = new Ajaxdata;

        // Assign validated data to the model attributes
        $newdata->name = $validateData['name'];
        $newdata->email = $validateData['email'];
        $newdata->mobile = $validateData['mobile'];

        // Save the data into the database
        $newdata->save();

        // Optionally, return a response
        return response()->json(['message' => 'Data saved successfully'], 200);
    }

    public function searchProducts(Request $request)
    {
        $formData = $request->input('formData');
        $formdataa = ucfirst($formData);

        $products = AddCat::where('cat', 'LIKE', '%' . $formdataa . '%')->distinct()->get();

        if (is_null($products)) {
            return response('<p>No results found</p>', 200);
        }

        $response = '';
        foreach ($products as $product) {
            $response .= '<li><a href="' . route('viewproduct', ['category' => $product->cat]) . '">' . htmlspecialchars($product->cat) . '</a></li>';
        }

        return response($response, 200);

        // return response($response, 200);
    }
}
