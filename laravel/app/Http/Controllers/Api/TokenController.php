<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\File;
use App\Models\User;


class TokenController extends Controller
{

    public function user(Request $request)
    {
       $user = User::where('email', $request->user()->email)->first();
      
       return response()->json([
           "success" => true,
           "user"    => $request->user(),
           "roles"   => $user->getRoleNames(),
       ]);
    }

    public function register(Request $request)
    {
        $validator = $request -> validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $validator['name'],
            'email' => $validator['email'],
            'password' => Hash::make($validator['password']),
        ]);

        $user->assignRole('author');

        $token = $user->createToken("authToken")->plainTextToken;
        // Token response
        return response()->json([
            "success"   => true,
            "authToken" => $token,
            "tokenType" => "Bearer"
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            // Get user
            $user = User::where([
                ["email", "=", $credentials["email"]]
            ])->firstOrFail();
            // Revoke all old tokens
            $user->tokens()->delete();
            // Generate new token
            $token = $user->createToken("authToken")->plainTextToken;
            // Token response
            return response()->json([
                "success"   => true,
                "authToken" => $token,
                "tokenType" => "Bearer"
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Invalid login credentials"
            ], 401);
        }
        
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "success"   => true,
            "message" => "OK.",
        ], 200);
    }

}
