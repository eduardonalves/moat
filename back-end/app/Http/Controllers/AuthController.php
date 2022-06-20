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


        $validator = Validator::make($request->all(), [
            'full_name' =>
            'required|string|max:255',
            'role' =>
            'required|integer',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $validatedData = $validator->validated();
        $role = 2;
        $token_type = 'user';

        if ($validatedData['role'] == 1) {
            $role = 1;
            $token_type = 'admin';
        } else {
            $role = 2;
            $token_type = 'user';
        }

        $user = User::create([
            'full_name' => $validatedData['full_name'],
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
            'role' => $role,
        ]);

        $token = $user->createToken('auth_token', [$token_type])->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => $token_type,
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('username', $request['username'])->firstOrFail();


        if ($user->role == 1) {
            $token_type = 'admin';
        } else {
            $token_type = 'user';
        }

        $token = $user->createToken('auth_token', [$token_type])->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => $token_type,
        ]);
    }
}
