<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Login user
    public function login(Request $request)
    {
        $fields = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        //check username
        $user = User::where('username', $fields['username'])->first();

        //chcek password
        if(!$user || !Hash::check($fields['password'], $user->password))
        {
            return response([
                'message' => 'Invalid Credentials'
            ], 401);
        }
        
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'role' => $user->role
        ];

        return response($response, 201);
    }

    //Logout User
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}