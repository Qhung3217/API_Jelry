<?php

namespace App\Http\Controllers\Api;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WrapperResource;
use App\Models\material;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new WrapperResource(Categories::all());
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
        $this->validate(
            $request,
            [
                'name' => 'unique:categories,category_name',
            ],
            [
                'name.unique' => 'Category name is already exits'
            ]
        );
        try{
            $data = [
                "category_name" => $request->input("name"),
                "material_id" => $request->input("parentId"),
                'category_slug' => \Str::slug($request->input("name")),
            ];
            // $request->merge([
            //     'category_slug' => \Str::slug($request->input('category_name')),
            // ]);
            Categories::create($data);
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
     * @param  \App\Models\categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show($category_id)
    {
        try {
            $data['category'] = Categories::findOrFail($category_id);
            $data['material'] = Material::findOrFail($category_id);
            return $data;
        } catch (ModelNotFoundException $e) {
            $message = "Category Id not found!";
            return $message;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categories $category)
    {
        // $this->validate(
        //     $request,
        //     [
        //         'name' => 'unique:categories,category_name',
        //     ],
        //     [
        //         'name.unique' => 'Category name is already exits'
        //     ]
        // );

        try {
            $data = [
                "category_name" => $request->input("name"),
                "material_id" => $request->input("parentId"),
                'category_slug' => \Str::slug($request->input("name")),
            ];
            $isExist = Categories::where('category_id',$category->category_id)->where('material_id',$data['material_id'])->get();
            // return $isExist->count();
            if ($isExist->count() !== 0){
                return response()->json([
                    'message' => "Category name is already exits",
                    'error' => true
                ]);
            }
            $category->update($data);
            return response()->json([
                'message' => "Update category recored succesfully",
                'error' => false
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => "Update category recored failed",
                'error' => true
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categories $category)
    {
        try {
            $category->delete();
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
