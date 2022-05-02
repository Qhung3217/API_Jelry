<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MaterialResource;

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
                'name' => 'unique:materials,material_name',
            ],
            [
                'name.unique' => 'Material name is already exits'
            ]
        );
        try{
            $data = [
                "material_name" => $request->input("name"),
                'material_slug' => \Str::slug($request->input("name")),
            ];


            Material::create($data);
            return response()->json([
                'message' => "Create successfully!!",
                'error' => false
            ]);
        }catch(Exception $e){
            return response()->json([
                'message' => "Create failed. Try again!",
                'error' => true
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\material  $material
     * @return \Illuminate\Http\Response
     */
    /**
     *   $categories = Material::find($material_id)->category;
     *   $id = [];
     *   foreach ($categories as $category){
     *       $id[] = $category->category_id;
     *   }
     *   $productList= Product::whereIn('category_id',$id)->get();
     *   return ProductResource::collection($productList);
     */
    public function show($material_id)
    {
        try {
            $data = Material::findOrFail($material_id);
            return $data;

        } catch (Exception $e) {
            $message = "Material Id not found!";
            return $message;
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $material_id)
    {
        $this->validate(
            $request,
            [
                'name' => 'unique:materials,material_name',
            ],
            [
                'name.unique' => 'Material name is already exits'
            ]
        );
        try {
            $data = [
                'material_name' => $request->input('name'),
                'material_slug' => \Str::slug($request->input('name'))
            ];
            $material = Material::find($material_id);
            if (is_null($material)) {
                return response()->json([
                    'message' => "Material is not exist",
                    'error' => true
                ],400);
            }
            $material->update($data);
            return response()->json([
                'message' => "Update material recored succesfully",
                'error' => false
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => "Update material recored failed",
                'error' => true
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy($material_id)
    {
        try {
            $material = Material::find($material_id);
            if (is_null($material)) {
                return response()->json([
                    'message' => "Category is not exist",
                    'error' => true
                ],400);
            }
            $material->delete();
            return response()->json([
                'message' => "Delete successfully!",
                'error' => false
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => "Delete failed! Try again",
                'error' => true
            ]);
        }
    }
}
