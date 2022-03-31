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
Route::resource('material', 'App\Http\Controllers\Api\MaterialController')->except(['edit','create']);
Route::resource('category', 'App\Http\Controllers\Api\CategoriesController')->except(['edit','create']);
Route::resource('invoice-detail', 'App\Http\Controllers\Api\InvoiceDetailController')->only(['update','store']);
Route::resource('invoice', 'App\Http\Controllers\Api\InvoiceController')->except(['edit','create']);
Route::resource('product', 'App\Http\Controllers\Api\ProductController')->except(['edit','create']);
Route::resource('size', 'App\Http\Controllers\Api\SizeController')->only(['index','show','store','update','destroy']);
Route::resource('product-size', 'App\Http\Controllers\Api\ProductSizeController')->only(['store','update','destroy']);
Route::resource('image', 'App\Http\Controllers\Api\ImageController')->except(['edit','create']);
