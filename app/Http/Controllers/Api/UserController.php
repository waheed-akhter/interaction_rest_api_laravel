<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // AUTHENTICATE USER
    function login(Request $req)
    {
        $req->validate([ 
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);  

        if(!auth()->attempt(['email' => $req->email, 'password' => $req->password]))
        {
            return response()->json(['status' => 403, 'message' => 'Invalide Password, Please Try Again.', 'data' => null]);
        }
 
        $user = User::where('email', $req->email)->first();
        $jwt = $user->createToken('auth-token')->plainTextToken;

        return response()->json(['status' => 200, 'message' => 'login succcessfuly', 'data' => $user, 'jwt_token' => $jwt]);
    }  

    // STORE USER INFO 
    function register(Request $req)
    {  
        $req->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);  

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
        ]);

        return response()->json(['status' => 200, 'data' => $user]); 
    }
} 
