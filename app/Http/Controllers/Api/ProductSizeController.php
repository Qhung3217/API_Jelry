<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            for ($i = 0 ; $i < count($request->input('size_id')) ; $i++){
                $input[] = [
                    'size_id' => $request->input('size_id')[$i],
                    'product_id' => $request->input('product_id'),
                    'product_size_quantily' => $request->input('product_size_quantily')[$i]
                ];
            }
            // return $input;
            ProductSize::insert($input);
            $message = "Create successfully!!";
        }catch(Exception $e){
            $message = "Create failed. Try again!";
        }
        return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductSize  $productSize
     * @return \Illuminate\Http\Response
     */
    public function show($product_id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductSize  $productSize
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductSize $productSize)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductSize  $productSize
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id)
    {
        try {
            $productSize = Product::find($product_id);
            // return [$productSize,$productSize->isEmpty()];
            if ($productSize != null) {
                $data = $request->input();
                if ($request->input('size_id_new')){
                    $data['size_id']=$data['size_id_new'];
                    unset($data['size_id_new']);
                    unset($data['size_id_current']);
                }else{
                    $data['size_id']=$request->input('size_id_current');
                    unset($data['size_id_current']);
                }
                $productSize->size()->updateExistingPivot($request->input('size_id_current'),$data);
                return "Update Successfully";
            }else
                return "Error, primary key not found";
        } catch (Exception $e) {
            // return "Error, update failed";
            return $e->getMessage();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductSize  $productSize
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $product_id)
    {
        try {
            $productSize = Product::find($product_id);
            if ($productSize != null) {
                $productSize->size()->detach($request->input('size_id'));
                $message = "Delete successfully!";
                return $message;
            }
            else{
                $message = "Error, primary key not found";
                return $message;
            }
        } catch (Exception $e) {
            $message = "Delete failed!";
            return $message;
        }
    }
}
