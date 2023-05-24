<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $attrs = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $attrs['name'],
            'email' => $attrs['email'],
            'password' => bcrypt ($attrs['password'])
        ]);

        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ]);
    }

    public function login (Request $request)
    {
        $attrs = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (!Auth::attempt($attrs)) {

            return response([
                'message' => 'Credenciales invalidas'
            ],403);    
        }

        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ],200);
    }

    public function logout()
    {
        auth()->user()->token()->delete();
        return response([
            'message' => 'logout success'
        ],200);
    }
}
