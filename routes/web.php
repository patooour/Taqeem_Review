<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

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

Route::get('/test', function () {
    return view('test');
});


Route::get('/search',[CategoryController::class , 'search']);
Route::get('/',[CategoryController::class , 'getMainCategory'])->name('main_category');
Route::get('/category/{id}',[CategoryController::class , 'getBrands'])->name('Brand');
Route::get('/product/{id}',[productController::class , 'getProduct'])->name('Product');
Route::get('/product/review/{id}',[productController::class , 'getProductReview'])->name('Review');


Route::group(['middleware' => ['auth:web']], function () {
    // Route::post('/product/review/{id}', [productController::class, 'add review'])->name('addReview');
    Route::get('/logout',[AuthController::class , 'doLogout']);
    Route::post('/product/review/{id}',[productController::class , 'addReview'])->name('Add.Review');

});


Route::get('/login',[AuthController::class , 'getLogin'])->name('login');
Route::post('/doRegister',[AuthController::class , 'doRegister'])->name('Register');
Route::post('/doLogin',[AuthController::class , 'doLogin'])->name('doLogin');
