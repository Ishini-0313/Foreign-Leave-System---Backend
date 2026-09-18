<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function forgotPassword(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status == Password::RESET_LINK_SENT){
            return response()->json([
                'message' => 'Password reset link sent successfully.'
            ]);
        }

        return response()->json([
            'message' => 'Unable to send reset link.'
        ], 400);
    }

    public function resetPassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);

        $status = Password::reset(
            $request->only(
                'email', 'password', 'password_confirmation', 'token'
            ),function($user, $password){
                $user->hash_password = Hash::make($password);
                $user->save();
            }
        );

        if($status == Password::PASSWORD_RESET){
            return response()->json([
                'message'=>'Password reset successfully.'
            ]);
        }

        return response()->json([
            'message'=>'Invalid or expired token.'
        ],400);
    }
}
