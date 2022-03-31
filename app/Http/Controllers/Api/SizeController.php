<?php

namespace App\Http\Controllers\Api;

use App\Models\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WrapperResource;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new WrapperResource(Size::all());
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
            $data = [
                "size_name" => $request->input("name"),
            ];
            Size::create($data);
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
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function show($size)
    {
        try {
            $data = Size::findOrFail($size);
            return $data;

        } catch (Exception $e) {
            return response()->json([
                'message' => "Material Id not found!",
                'error' => false
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function edit(Size $size)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Size $size)
    {

        try {
            $data = [
                'size_name' => $request->input('name'),
            ];
            $size->update($data);
            return response()->json([
                'message' => "Update size recored succesfully",
                'error' => false
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Update size recored failed",
                'error' => true
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function destroy(Size $size)
    {
        try {
            $size->delete();
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
