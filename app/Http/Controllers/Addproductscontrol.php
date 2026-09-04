<?php

namespace App\Http\Controllers;

use App\Models\AddCat;
use App\Models\AddProduct;
use App\Models\AddSubCat;
use App\Models\Ajaxdata;
use App\Models\ProductAdd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Addproductscontrol extends Controller
{
    public function addprod(Request $request)
    {
        // Extract incoming request data
        $validatedData = $request->validate([
            'Productname' => 'required',
            'Description' => 'required',
            'category' => 'required',
            'subcat' => 'required', // Ensure subcat exists in subcategories table
            'Price' => 'required|numeric',
        ]);

        $imageNames = [];

        // File upload handling
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/addproduct'), $imageName);
                $imageNames[] = $imageName;
            }
        }
        $product = new AddProduct();
        $product->Productname = $request->input('Productname');
        $product->description = $request->input('Description');
        $product->cat = $request->input('category');
        $product->subcat = $request->input('subcat');
        $product->price = $request->input('Price');
        $product->images = json_encode($imageNames); // Assuming images are submitted as an array
        $product->save();
        return redirect()->route('admin.addproduct');
    }

    /**
     * Show the edit form for a single product, pre-filled with its current data.
     */
    public function editForm($id)
    {
        $product = AddProduct::findOrFail($id);
        $categories = AddCat::select('*')->get();
        $subcategories = AddSubCat::where('cat', $product->cat)->get();

        return view('admin.editproduct', compact('product', 'categories', 'subcategories'));
    }

    /**
     * Update an existing product: fields, plus optional new images and
     * optional removal of existing images.
     */
    public function updateProd(Request $request, $id)
    {
        $product = AddProduct::findOrFail($id);

        $request->validate([
            'Productname' => 'required',
            'Description' => 'required',
            'category' => 'required',
            'subcat' => 'required',
            'Price' => 'required|numeric',
            'images.*' => 'nullable|image',
        ]);

        // Start from the images currently saved on the product
        $existingImages = json_decode($product->images, true) ?: [];

        // Drop any images the admin explicitly marked for removal
        $imagesToRemove = $request->input('remove_images', []);
        if (!empty($imagesToRemove)) {
            foreach ($imagesToRemove as $imageName) {
                $path = public_path('images/addproduct/' . $imageName);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
            $existingImages = array_values(array_diff($existingImages, $imagesToRemove));
        }

        // Append any newly uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/addproduct'), $imageName);
                $existingImages[] = $imageName;
            }
        }

        // A product must keep at least one image
        if (empty($existingImages)) {
            return back()
                ->withErrors(['images' => 'A product needs at least one image — add a new one before removing the last one.'])
                ->withInput();
        }

        $product->Productname = $request->input('Productname');
        $product->description = $request->input('Description');
        $product->cat = $request->input('category');
        $product->subcat = $request->input('subcat');
        $product->price = $request->input('Price');
        $product->images = json_encode($existingImages);
        $product->save();

        return redirect()->route('admin.listproduct')->with('status', 'Product updated.');
    }

    /**
     * Delete a product and its uploaded image files.
     */
    public function deleteProd($id)
    {
        $product = AddProduct::findOrFail($id);

        $images = json_decode($product->images, true) ?: [];
        foreach ($images as $imageName) {
            $path = public_path('images/addproduct/' . $imageName);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $product->delete();

        return redirect()->route('admin.listproduct')->with('status', 'Product deleted.');
    }

    public function usersdata()
    {
        $exploreuser = Ajaxdata::all();
        return view('admin.usersdata', compact('exploreuser'));
    }
}
