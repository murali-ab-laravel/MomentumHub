<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            // Require either email or username
            'email' => 'required_without:username|email',
            'username' => 'required_without:email|string',
        ]);

        // Determine which field to use for login
        $loginField = $request->filled('email') ? 'email' : 'username';

        $credentials = [
            $loginField => $request->input($loginField),
            'password' => $request->input('password'),
        ];

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => auth()->user(),
            'role' => auth()->user()->getRoleNames() 
        ]);
    }
}
