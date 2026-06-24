<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if(!$user){
            return response()->json([
                'message' => 'Invalid username'
            ], 401);
        }

        if(!Hash::check($request->password, $user->hash_password)){
            return response()->json([
                'message' => 'Incorrect password'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => 'Login successful',
            'user' => $user
        ]);
    }
}
