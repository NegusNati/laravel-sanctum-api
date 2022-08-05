<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Constraints for validating user creation fields
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed', //the 'confirmed' requie us to input password_confirm field
        ]);

        //create the registered user 
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);
        //token of the user 
        $token = $user->createToken('myappToken')->plainTextToken;

        // the response to the registerd user, to access protected routes
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }


    public function login(Request $request)
    {
        // we don't need the name for login
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check Password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }


        //token of the user 
        $token = $user->createToken('myappToken')->plainTextToken;

        // the response to the registerd user, to access protected routes
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    // delete the token while logout
    public function logout(Request $request)
    {

        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Tokens Destroyed & Successfully logged out');

        // auth()->user()->tokens()->delete();
        // return response([
        //     'message' => 'Token Destroyed and Logged out'
        // ]);

    }
}
