<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(),
        [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 400);
        }

        $user = User::create($request->all());
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(
            [
                'message' => 'User created successfully',
                'user' => $user,
                'token' => $token
            ], 201
        );
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(),
        [            
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password))
        {
            return response()->json([
                'message' => 'Invalid login credentials'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(
            [
                'message' => 'User login successfully',
                'user' => $user,
                'token' => $token
            ], 200
        );
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ], 200);
    }
}
