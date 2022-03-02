<?php

namespace App\Http\Controllers\Api;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WrapperResource;
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
        try{
            $request->merge([
                'category_slug' => \Str::slug($request->input('category_name')),
            ]);
            Categories::create($request->input());
            $message = "Create successfully!!";
        }catch(Exception $e){
            $message = "Create failed. Try again!";
        }
        return $message;
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
            $data["categories"] = Categories::findOrFail($category_id);
            $data["products"] = Categories::findOrFail($category_id)->product;
            return new WrapperResource($data);
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
        try {
            if ($request->input('category_name'))
                $request->merge([
                    'category_slug' => \Str::slug($request->input('category_name')),
                ]);
            $category->update($request->all());
            $message = "Update category recored succesfully";
            return $message;
        } catch (Exception $e) {
            $message = "Update category recored failed";
            return $message;
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
            $message = "Delete successfully!";
            return $message;
        } catch (Exception $e) {
            $message = "Delete failed!";
            return $message;
        }
    }
}
