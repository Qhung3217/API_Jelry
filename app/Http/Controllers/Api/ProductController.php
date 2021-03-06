<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use File;
use App\Models\Image;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::all();
        return ProductResource::collection($data);
    }
    public function show($product_id)
    {
        try {
            $data = Product::find($product_id);
            if (is_null($data))
                return response()->json([
                    'message' => 'Product id not found!',
                    'error' => true
                ],400);
            $data->size;
            $data->image;
            return $data;
            // return ProductResource::collection($data);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true
            ],500);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'unique:products,product_name',
            ],
            [
                'name.unique' => 'Product name is already exits'
            ]
        );
        DB::beginTransaction();
        try{
            $product = [
                "product_name" => $request->input("name"),
                "product_slug" => \Str::slug($request->input("name")),
                "product_price" => $request->input("price"),
                "product_desc" => $request->input("desc"),
                "category_id" => $request->input("cate")
            ];
            $product = Product::create($product);
            $images = $request->image;
            foreach ($images as $image){
                $path = 'uploads/'. date('Y-m-d');
                $name = time().rand(1,100).'.'.$image->extension();
                $image->move(public_path($path), $name);
                $pathFull = $path . '/' . $name;
                $data = [
                    'product_id' => $product->product_id,
                    'image_url' => $pathFull
                ];
                Image::create($data);
            }
            $sizes = $request->size;
            $quantities = $request->quantity;
            // return response()->json($sizes);
            for($i = 0 ; $i < count($sizes) ; $i++) {
                $data = [
                    'product_id' => $product->product_id,
                    'size_id' => $sizes[$i],
                    'product_size_quantily' => $quantities[$i]
                ];
                ProductSize::create($data);
            }
            DB::commit();
            return response()->json([
                'message' => "Create successfully!!",
                'error' => false
            ],200);
        }catch(QueryException $e){
            DB::rollback();
            return response()->json([
                'message' => "Create failed. Try again!",
                'error' => true
            ],500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id)
    {
        try {

            $data = [
                "product_name" => $request->input("name"),
                "product_slug" => \Str::slug($request->input("name")),
                "product_price" => $request->input("price"),
                "product_desc" => $request->input("desc"),
                "category_id" => $request->input("cate")
            ];
            $product = Product::find($product_id);
            if (is_null($product)){
                return response()->json([
                    'message' => "Product is not exist",
                    'error' => true
                ],400);
            }
            if ($product->product_slug !== $data['product_slug']) {
                $this->validate(
                    $request,
                    [
                        'name' => 'unique:categories,category_name',
                    ],
                    [
                        'name.unique' => 'Category name is already exits'
                    ]
                );
            }

            DB::beginTransaction();
            $product->update($data);
            if ($request->image){
                $images = Image::where("product_id", $product->product_id)->get();
                foreach ($images as $image){
                    if (File::exists(public_path($image['image_url'])))
                        File::delete(public_path($image['image_url']));
                }
                Image::where("product_id",$product->product_id)->delete();
                $images = $request->image;
                foreach ($images as $image){
                    $path = 'uploads/'. date('Y-m-d');
                    $name = time().rand(1,100).'.'.$image->extension();
                    $image->move(public_path($path), $name);
                    $pathFull = $path . '/' . $name;
                    $data = [
                        'product_id' => $product->product_id,
                        'image_url' => $pathFull
                    ];
                    Image::create($data);
                }
            }
            ProductSize::where('product_id', $product->product_id)->delete();
            $sizes = $request->size;
            $quantities = $request->quantity;
            for($i = 0 ; $i < count($sizes) ; $i++) {
                $data = [
                    'product_id' => $product->product_id,
                    'size_id' => $sizes[$i],
                    'product_size_quantily' => $quantities[$i]
                ];
                ProductSize::create($data);
            }
            DB::commit();
            return response()->json([
                'message' => "Update product recored succesfully",
                'error' => false
            ],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => "Update product recored failed",
                'error' => true,
                'ss' => $e->getMessage(),
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        try {
            $product = Product::find($product_id);
            if (is_null($product)){
                return response()->json([
                    'message' => "Product is not exist",
                    'error' => true
                ],400);
            }
            $product->delete();
            return response()->json([
                'message' => "Delete successfully!",
                'error' => false
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'message' => "Delete failed! Try again",
                'error' => true
            ],500);
        }
    }
}
