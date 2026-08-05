<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public function show(Request $request){
        return response()->json(
            $request->user()->load(['office', 'role'])
        );
    }

    public function update(Request $request){
        $user = $request->user();


        $request->validate([
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone'=>'required',
            'designation'=>'required'
        ]);

        $user->update([
            'full_name'=>$request->full_name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'designation'=>$request->designation
        ]);

        return response()->json([
            'message' => 'Profile updated successfully!'
        ]);
    }

    public function changePassword(Request $request){
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = $request->user();

        if(!Hash::check($request->current_password, $user->hash_password)){
            return response()->json([
                'message' => 'Current password is incorrect'
            ], 422);
        }

        $user->update([
            'hash_password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'message' => 'Password changed successfully!'
        ]);
    }
}
