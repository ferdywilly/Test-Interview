<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "email" => "required|string|max:255",
            "password" => "required|string|max:255",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Failed to create User",
                "data" => $validator->errors()
            ], 403);
        }
    
        $user = User::where("email", $request->email)->first();

        if($user){
            return response()->json([
                "message" => "Email already exist, use another email.",
            ], 403);
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => password_hash($request->password, PASSWORD_DEFAULT),
        ]);

        return response()->json(["message" => "User registered successfully", "user" => $user], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|string|max:255",
            "password" => "required|string|max:255",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Failed to Login User",
                "data" => $validator->errors()
            ], 403);
        }

        $user = User::where("email", $request->email)->first();
        if(!$user){
            return response()->json([
                "errors" => [
                    "email" => "email doesnt exist.",
                ]
            ], 404);
        }elseif($user && password_verify($request->password, $user->password)){
            return response()->json([
                "message" => "Login Successfully",
            ], 200);
        } else{
            return response()->json([
                "errors" => [
                    "password" => "password not match.",
                ]
            ], 404);
        }
    }
}
