<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AddProduct;

class PdfController extends Controller
{
    public function generatePdf(Request $request)
{
    $data = ['title' => 'Welcome to Laravel PDF!'];

$pdf = PDF::loadView('viewproducts', $data);

// To view the PDF in the browser
return $pdf->stream('example.pdf');
}

        // return view('viewproduct', [
        //     'products' => $products,
        //     'category' => $category,
        //     'allproducts'=>$allproducts,
        // ]);

    // }
}
