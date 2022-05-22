<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\ProductCustController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartDetailControlle;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TrackingCustController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\NavbarController;
use App\Http\Livewire\ShopComponent;
use App\Http\Livewire\ChekoutComponent;
use App\Http\Livewire\CartComponent;
use App\Http\Livewire\DetailsComponent;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/coming', function () {
    return view('pages.coming');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::get('/', [homeController::class, 'index']);

Route::get('/admin',[App\Http\Controllers\DashboardController::class,
'index'])->middleware(['auth'])->name('index.dashboard');
Route::post('/admin',[App\Http\Controllers\DashboardController::class,
'index'])->middleware(['auth'])->name('index.dashboard');

Route::get('/home',[App\Http\Controllers\homeController::class,
'index'])->middleware(['auth'])->name('home.pages');
Route::post('/home',[App\Http\Controllers\homeController::class,
'index'])->middleware(['auth'])->name('home.pages');

// Route::group(['prefix' => 'admin'], function() {
//     Route::resource('produk','App\Http\Controllers\ProductController')->middleware(['auth']);
// });

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

require __DIR__.'/auth.php';

Route::group(['prefix' => 'admin'], function() {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('produk', 'App\Http\Controllers\ProductController')->middleware(['auth']);;
    Route::resource('katalog', 'App\Http\Controllers\KatalogController')->middleware(['auth']);;
    Route::resource('transaksi', 'App\Http\Controllers\TransaksiController')->middleware(['auth']);;
    Route::resource('customer', 'App\Http\Controllers\CustomerController')->middleware(['auth']);;
    // image
    Route::get('image', [ImageController::class, 'index']);
    // simpan image
    Route::post('image', [ImageController::class, 'store']);
    // hapus image by id
    Route::delete('image/{id}', [ImageController::class, 'destroy']);
    
    Route::post('imagekategori', [KatalogController::class, 'uploadimage']);
    // hapus image kategori
    Route::delete('imagekategori/{id}', [KatalogController::class, 'deleteimage']);
    // upload image produk
    Route::post('produkimage', [ProductController::class, 'uploadimage']);
    // hapus image produk
    Route::delete('produkimage/{id}', [ProductController::class,'deleteimage']);
});
// shopping cart
Route::group(['middleware' => 'auth'], function() {
    // cart
    Route::resource('trolley', 'App\Http\Controllers\CartController');
    Route::patch('kosongkan/{id}', [CartController::class, 'kosongkan']);
    // cart detail
    Route::resource('cartdetail', 'App\Http\Controllers\CartDetailController');
    
    Route::resource('order', 'App\Http\Controllers\DetailOrderController');
    // checkout
    Route::get('checkout', [CartController::class, 'checkout'])->name('pages.checkout');
    //tracking
    Route::get('tracking', [TrackingCustController::class, 'index']);
    //history
    Route::resource('history', 'App\Http\Controllers\HistoryController');
    //navbar
    Route::get('navbar', [NavbarController::class, 'index'])->name('components.navbar2');
});

Route::get('/kategori', [homeController::class, 'index'])->middleware(['auth']);;
Route::get('/kategori/{id}', [homeController::class, 'kategoribyid']);
Route::get('/produk/{id}', [homeController::class, 'produkdetail']);

Route::get('/kategori/product/{id}', [homeController::class, 'produkdetail']);

//search tracking
Route::get('/tracking/search', [TrackingCustController::class,'search']);
//search produk
Route::get('/product/search', [ProductCustController::class,'search']);
//search customer
Route::get('/admin/customer/search', [CustomerController::class, 'search'])->middleware(['auth']);;

Route::resource('product', 'App\Http\Controllers\ProductCustController');
Route::get('about', [homeController::class, 'about']);

// Route::get('/about', function () {
//     return view('pages.about');
// });
// Route::get('/tracking', function () {
//     return view('pages.tracking-2');
// });



// Route::get('/menu', [DashboardController::class, 'menu'])->name(['menu']);;


// Route::get('/shop', ShopComponent::class);
// Route::get('/cart', CartComponent::class)->name('produk.cart');
// Route::get('/chekout', ChekoutComponent::class);
// Route::get('/detail/{id}', DetailsComponent::class)->name('produk.details');


