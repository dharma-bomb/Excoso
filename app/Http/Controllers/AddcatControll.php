<?php

namespace App\Http\Controllers;

use App\Models\AddCat;
use App\Models\AddSubCat;
use Illuminate\Http\Request;

class AddcatControll extends Controller
{
    public function catadd(Request $addcat)
    {
        $cat = $addcat->input("category");
        $catadd = new AddCat;
        $catadd->cat = $cat;
        $catadd->save();
        return redirect()->route('admin.addcat');
    }

    public function listcat()
    {
        $categories = AddCat::select('*')->get(); // Fetch all categories
        return view('admin.addproduct', compact('categories'));
    }
}
