<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'email' => "required|string|email|unique:users",
            "password" => "required|string",
            "name" => "required|string"
        ]);
        $user = User::create([
            'email' => $request->email,
            "password" => Hash::make($request->password),
            "name" => $request->name
        ]);
        return response()->json([
        "status"=>1,
        "message" =>"User created"
    ]);
    }

    public function login(Request $request){
        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)){
            $user = $request->user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status'=> 1,
                "token" => $token
            ]);

        }
        return response()->json([
            'status' => 0,
        ],401);
    }

    protected function is_logged(){
        $user = Auth::user();
        if($user){
            return response()->json([
                'status' => '1',
                'user' => $user
            ]);
        }
        return response()->json([
            'status' => 0
        ],401);
    }
}