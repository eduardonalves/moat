<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        
        /*$validatedData = $request->validate([
            'full_name' =>
            'required|string|max:255',
            'role' =>
            'required|integer',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);*/
        $validator = Validator::make($request->all(), [
            'full_name' =>
            'required|string|max:255',
            'role' =>
            'required|integer',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
    
            //pass validator errors as errors object for ajax response

            return response()->json(['errors'=>$validator->errors()]);
        }
    
        $validatedData=$validator->validated();
        if( $validatedData['role'] == 1){
            $user = User::create([
                'full_name' => $validatedData['full_name'],
                'username' => $validatedData['username'],
                'password' => Hash::make($validatedData['password']),
                'role' => 1,
            ]);
    
            $token = $user->createToken('auth_token', ['admin'])->plainTextToken;
    
            return response()->json([
                'access_token' => $token,
                'token_type' => 'admin',
            ]);
        }else{
            $user = User::create([
                'full_name' => $validatedData['full_name'],
                'username' => $validatedData['username'],
                'password' => Hash::make($validatedData['password']),
                'role' => 2,
            ]);
    
            $token = $user->createToken('auth_token', ['user'])->plainTextToken;
    
            return response()->json([
                'access_token' => $token,
                'token_type' => 'user',
            ]);
        }
        
    }
    
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('username', $request['username'])->firstOrFail();

        
        if($user->role == 1){
            $token = $user->createToken('auth_token', ['admin'])->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'token_type' => 'admin',
            ]);
        }else{
            $token = $user->createToken('auth_token', ['user'])->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'token_type' => 'user',
            ]);
        }
        
    }
}
