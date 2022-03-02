<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\WrapperResource;
use App\Models\ProductSize;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::paginate(10);
        return ProductResource::collection($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $request->merge([
                'product_slug' => \Str::slug($request->input('product_name')),
            ]);
            Product::create($request->input());
            $message = "Create successfully!!";
        }catch(Exception $e){
            $message = "Create failed. Try again!";
        }
        return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($product_id)
    {
        try {
            $data = Product::findOrFail($product_id);
            $data->size;
            $data->image;
            return $data;
            // return ProductResource::collection($data);
        } catch (ModelNotFoundException $e) {
            $message = "Product Id not found!";
            return $message;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try {
            if ($request->input('product_name'))
                $request->merge([
                    'product_slug' => \Str::slug($request->input('product_name')),
                ]);
            $product->update($request->all());
            $message = "Update product recored succesfully";
            return $message;
        } catch (ModelNotFoundException $e) {
            $message = "Update product recored failed";
            return $message;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            $message = "Delete successfully!";
            return $message;
        } catch (Exception $e) {
            $message = "Delete failed!";
            return $message;
        }
    }
}
