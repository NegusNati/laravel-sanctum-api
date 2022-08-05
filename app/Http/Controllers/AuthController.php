<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
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
}
