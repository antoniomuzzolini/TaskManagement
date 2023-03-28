<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('TaskManagement')->plainTextToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function permissions(Request $request)
    {
        $user = $request->user();
        $permissions = $user->getAllPermissions()->pluck('name');
        return response()->json(['permissions' => $permissions]);
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens->each(function($token, $key) {
            $token->delete();
        });

        return response()->json(['message' => 'Logged out'], 200);
    }
}

?>