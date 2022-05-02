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
                'name' => 'required'
            ],
            [
                'name.required' => 'Size name is empty!'
            ]
        );
        try{
            $data = [
                "size_name" => $request->input("name"),
            ];
            Size::create($data);
            return response()->json([
                'message' => "Create successfully!!",
                'error' => false
            ],200);
        }catch(Exception $e){
            return response()->json([
                'message' => "Create failed. Try again!",
                'error' => true
            ],500);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $size_id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required'
            ],
            [
                'name.required' => 'Size name is empty!'
            ]
        );
        try {
            $data = [
                'size_name' => $request->input('name'),
            ];
            $size = Size::find($size_id);
            if (is_null($size)) {
                return response()->json([
                    'message' => "Size is not exist",
                    'error' => true
                ],400);
            }
            $size->update($data);
            return response()->json([
                'message' => "Update size recored succesfully",
                'error' => false
            ],200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Update size recored failed",
                'error' => true
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function destroy($size_id)
    {
        try {
            $size = Size::find($size_id);
            if (is_null($size)) {
                return response()->json([
                    'message' => "Size is not exist",
                    'error' => true
                ],400);
            }
            $size->delete();
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
