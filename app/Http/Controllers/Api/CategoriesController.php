<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Material;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WrapperResource;

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

    public function show($category_id)
    {
        try {
            $data['category'] = Categories::find($category_id);
            $data['material'] = Material::find($category_id);
            if (is_null($data['category']) || is_null($data['material'])) {}
                return response()->json([
                    'message' => 'Record not found!',
                    'error' => true
                ],400);
            return $data;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category_id)
    {

        try {
            $data = [
                "category_name" => $request->input("name"),
                "material_id" => $request->input("parentId"),
                'category_slug' => \Str::slug($request->input("name")),
            ];
            $category = Categories::find($category_id);
            if (is_null($category)) {
                return response()->json([
                    'message' => "Category is not exist",
                    'error' => true
                ],400);
            }
            if ($category->category_slug !== $data['category_slug']) {
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
    public function destroy($category_id)
    {
        try {
            $category = Categories::find($category_id);
            if (is_null($category)) {
                return response()->json([
                    'message' => "Category is not exist",
                    'error' => true
                ], 400);
            }
            $category->delete();
            return response()->json([
                'message' => "Delete successfully!",
                'error' => false
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => "Delete failed! Try again",
                'error' => true
            ], 500);
        }
    }
}
