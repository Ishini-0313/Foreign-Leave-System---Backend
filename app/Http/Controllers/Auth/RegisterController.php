<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nic' => 'required|string|unique:users,nic',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'designation' => 'required|string',
            'office_id' => 'required|integer',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'full_name' => $validated['full_name'],
            'nic' => $validated['nic'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'designation' => $validated['designation'],
            'office_id' => $validated['office_id'],
            'role_id' => 1,
            'username' => $validated['username'],
            'hash_password' => Hash::make($validated['password']),
            'status' => 'Active'
        ]);

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user
        ], 201);
    }
}

