<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(Request $request){
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];
        if (Auth::guard('admin')->attempt($credentials)){
            return response()->json([
                'status' => 'success',
                'token' => \Str::random(20)
            ]);
        }
        return response()->json([
            'status' => 'fail',
            'message' => 'Incorrect username or password'
        ]);
    }

    public function changePassword(Request $request){
        $this->validate(
            $request,
            [
                'oldPass' => 'required',
                'newPass' => 'required',
            ],
            [
                'oldPass.required' => 'Current password is required',
                'newPass.required' => 'New password is required'
            ]
        );
        try {
            $credentials = [
                'username' => 'admin',
                'password' => $request->oldPass
            ];
            if (Auth::guard('admin')->attempt($credentials)){
                $admin = Admin::where('username', 'admin')->first();

                $admin->password = bcrypt($request->newPass);
                $admin->save();
                return response()->json([
                    'message' => "Change password succesfully",
                    'error' => false
                ],200);
            }
            else
                return response()->json([
                    'message' => "Current password is incorrect",
                    'error' => true
                ],400);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Change password failed. Try again! " . $th->getMessage(),
                'error' => true
            ],500);
        }
    }
}
