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
                'newPass' => 'required',
            ],
            [
                'newPass.required' => 'New password is required'
            ]
        );
        try {
            $admin = Admin::where('username', 'admin')->first();
            $admin->password = bcrypt($request->newPass);
            $admin->save();
            return response()->json([
                'message' => "Change password succesfully",
                'error' => false
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Change password failed. Try again! " . $th->getMessage(),
                'error' => true
            ]);
        }
    }
}
