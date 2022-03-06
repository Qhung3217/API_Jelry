<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Product;
use App\Models\Material;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WrapperResource;
use App\Http\Resources\MaterialResource;
use App\Http\Resources\ProductResource;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return MaterialResource::collection(Material::all());
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
                'material_slug' => \Str::slug($request->input('material_name')),
            ]);
            Material::create($request->input());
            $message = "Create successfully!!";
        }catch(Exception $e){
            $message = "Create failed. Try again!";
        }
        return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\material  $material
     * @return \Illuminate\Http\Response
     */
    public function show($material_id)
    {
        try {
            // $data["material"] = Material::find($material_id);
            $categories = Material::find($material_id)->category;

            $id = [];
            foreach ($categories as $category){
                $id[] = $category->category_id;
            }
            $productList= Product::whereIn('category_id',$id)->get();
            return ProductResource::collection($productList);

        } catch (Exception $e) {
            $message = "Material Id not found!";
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(material $material)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        try {
            if ($request->input('material_name'))
                $request->merge([
                    'material_slug' => \Str::slug($request->input('material_name')),
                ]);
            $material->update($request->all());
            $message = "Update material recored succesfully";
            return $message;
        } catch (Exception $e) {
            $message = "Update material recored failed";
            return $message;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        try {
            $material->delete();
            $message = "Delete successfully!";
            return $message;
        } catch (Exception $e) {
            $message = "Delete failed!";
            return $message;
        }
    }
}
