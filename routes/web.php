<?php

use App\Http\Controllers\AddcatControll;
use App\Http\Controllers\IndexControll;
use App\Http\Controllers\Addproductscontrol;
use App\Http\Controllers\AdminRegister;
use App\Http\Controllers\AjaxControler;
use App\Http\Controllers\demoController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\Productsdetail;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SubCatController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\ViewPageControl;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckSession;


Route::get('/', [IndexControll::class, 'indexdata']);

// Every admin route below (except login/register) now requires an active
// admin session — previously only /admin/dashboard checked this, so
// /admin/listproduct, /admin/addproduct, etc. were reachable by anyone who
// knew the URL. See CheckSession::handle().
Route::prefix('admin')->name('admin.')->middleware(CheckSession::class)->group(function () {
    Route::view('login', 'admin.login')->name('login');
    Route::view('register', 'admin.register')->name('register');
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');
    Route::get('addproduct', [AddcatControll::class, 'listcat'])->name('addproduct');
    Route::get('listproduct', [ProductsController::class, 'productList'])->name('listproduct');
    Route::get('editproduct/{id}', [Addproductscontrol::class, 'editForm'])->name('editproduct');
    Route::post('updateproduct/{id}', [Addproductscontrol::class, 'updateProd'])->name('updateproduct');
    Route::post('deleteproduct/{id}', [Addproductscontrol::class, 'deleteProd'])->name('deleteproduct');
    Route::view('addcat', 'admin.addcat')->name('addcat');
    Route::get('addsubcat', [SubCatController::class, 'listsubcat'])->name('addsubcat');
    Route::get('usersdata', [Addproductscontrol::class, 'usersdata'])->name('usersdata');
    Route::get('quotes', [QuoteController::class, 'adminList'])->name('quotes');
    Route::post('quotes/{id}/delete', [QuoteController::class, 'deleteQuote'])->name('quotes.delete');
});

Route::post('adminreg', [AdminRegister::class, 'registeradmin']);
Route::post('adminlog', [AdminRegister::class, 'registerlog']);
// These three write to the product/category tables directly, so they carry
// the same admin-session check as the /admin/* pages that link to them.
Route::post('add_prod', [Addproductscontrol::class, 'addprod'])->middleware(CheckSession::class);
Route::post('addingcat', [AddcatControll::class, 'catadd'])->middleware(CheckSession::class);
Route::post('addingsubcat', [SubCatController::class, 'subcatadd'])->name('addingsubcat')->middleware(CheckSession::class);



Route::get('subcategories', [SubCatController::class, 'listingsubcat'])->name('subcategories');



Route::prefix('view')->name('view.')->group(function () {
    Route::get('bags', [ViewController::class, 'viewproducts'])->name('bags');
    Route::get('caps', [ViewController::class, 'viewproducts'])->name('caps');
    Route::get('jackets', [ViewController::class, 'viewproducts'])->name('jackets');
    Route::get('raincoats', [ViewController::class, 'viewproducts'])->name('raincoats');
    Route::get('tshirts', [ViewController::class, 'viewproducts'])->name('tshirts');
    Route::get('umberlla', [ViewController::class, 'viewproducts'])->name('umberlla');
});


Route::get('fetchproducts', [AjaxControler::class, 'fetchProducts'])->name('fetchproducts');


Route::get('/tabs', [demoController::class, 'demoindex']);

Route::get('/viewproducts/{category}', [ViewPageControl::class, 'viewProduct'])->name('viewproduct');


Route::get('/viewproducts', [PdfController::class, 'generatePdf'])->name('viewproducts');

Route::post('formajax', [AjaxControler::class, 'formsubmit'])->name('formajax');

// Homepage "Get a Quote" enquiry form — saves to the database and attempts
// to email sales@expertcorporatesolutions.com. No login required: this is
// a public-facing lead form, same as the existing popup above.
Route::post('quote', [QuoteController::class, 'submitQuote'])->name('quote.submit');

Route::get('/search', function(){
    return view('search');
});
Route::post('searchprod', [AjaxControler::class, 'searchProducts'])->name('searchprod');



