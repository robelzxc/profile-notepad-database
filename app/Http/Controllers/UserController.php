<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class UserController extends Controller
{
    function getUsers(){
        return User::all();
    }
    function searchUser($id){
        return User::find($id);
    }
    function searchEmail($email){
        return User::where('email','like','%'.$email.'%')->get();
    }
    //
    function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'success' => true,
            'user' => $user,
            'token' => $token
        ];
        
        return response($response, 201);
    }
    function logout(Request $request){
        auth()->user()->tokens()->delete();
        
        return [
            'message' => 'Logged out successfuly'
        ];
    }

    function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'success' => false,
                'message' => 'Bad credentials'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'success' => true,
            'user' => $user,
            'token' => $token
        ];
        
        return response($response, 201);
    }

    // function login(Request $request){
    //     $user = User::where('email', $request->email)->first();

    //     if (!$user || !Hash::check($request->passowrd, $user->password)){
    //         return response([
    //             'message'=> ['These credentials do not match our records.']
    //         ],404);
    //     }
        
    //     $token = $user->createToken('my-app-token')->plainTextToken;

    //     $response = [
    //         'user' => $user,
    //         'token' => $token
    //     ];

    //     return response($response, 201);
    // }
    
}
