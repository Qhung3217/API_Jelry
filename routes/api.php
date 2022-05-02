<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('', function(){
    return view('Welcome');
});
Route::resource('material', 'App\Http\Controllers\Api\MaterialController')->only(['index','store','update','destroy']);
Route::resource('category', 'App\Http\Controllers\Api\CategoriesController')->only(['index','store','update','destroy']);
Route::resource('invoice', 'App\Http\Controllers\Api\InvoiceController')->only(['index','store','destroy']);
Route::resource('product', 'App\Http\Controllers\Api\ProductController')->only(['index','store','update','destroy']);
Route::resource('size', 'App\Http\Controllers\Api\SizeController')->only(['index','store','update','destroy']);

route::get('income', 'App\Http\Controllers\Api\InvoiceController@income');
route::post('login', 'App\Http\Controllers\Api\AdminController@login');
route::post('change-password', 'App\Http\Controllers\Api\AdminController@changePassword');

// Route::resource('invoice-detail', 'App\Http\Controllers\Api\InvoiceDetailController')->only(['update','store']);
// Route::resource('product-size', 'App\Http\Controllers\Api\ProductSizeController')->only(['store','update','destroy']);
// Route::resource('image', 'App\Http\Controllers\Api\ImageController')->except(['edit','create']);
