<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //REGISTER 
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string', 
            'email' => 'required|email|unique:users', 
            'password' => 'required|string|min:6', 
        ]);

        $user = User::create([
            'name' => $request->name, 
            'email' => $request->email, 
            'password' => Hash::make($request->password), 
        ]);
        
        $token = $user->createToken('auth_token')->plainTextToken; 

        return response()->json([
            'user' => $user, 
            "token" => $token
        ]);

    }

    //LOGIN 
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email', 
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first(); 

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken; 

        return response()->json([
            'user' => $user, 
            "token" => $token
        ]);
    } 
}
