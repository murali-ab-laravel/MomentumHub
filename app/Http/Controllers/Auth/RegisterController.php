<?php
// app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


use Tymon\JWTAuth\Contracts\JWTSubject;

use Tymon\JWTAuth\Facades\JWTAuth;


use Exception;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {

            $data = $request->validated();

            $user = User::create([
                'username'      => $data['username'],
                'first_name'    => $data['first_name'],
                'middle_name'   => $data['middle_name'] ?? null,
                'last_name'     => $data['last_name'],
                'email'         => $data['email'],
                'gender'        => $data['gender'],
                'date_of_birth' => $data['date_of_birth'],
                'phone'         => $data['phone'],
                'password'      => Hash::make($data['password']),
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'status'  => true,
                'message' => 'User registered successfully',
                'user'    => $user,
                'token'   => $token,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Registration failed. Please try again.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = auth()->user();

            $validatedData = $request->validate([
                'username'      => 'sometimes|string|max:255|unique:users,username,' . $user->id,
                'first_name'    => 'sometimes|string|max:255',
                'middle_name'   => 'nullable|string|max:255',
                'last_name'     => 'sometimes|string|max:255',
                'email'         => 'sometimes|email|max:255|unique:users,email,' . $user->id,
                'gender'        => 'sometimes|in:male,female,other',
                'date_of_birth' => 'sometimes|date',
                'phone'         => 'sometimes|string|max:20|unique:users,phone,' . $user->id,
            ]);

            $user->update($validatedData);

            return response()->json([
                'status'  => true,
                'message' => 'Profile updated successfully',
                'user'    => $user,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Profile update failed. Please try again.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    function getUserProfile()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User not found'], 404);
            }

            return response()->json([
                'status' => true,
                'user'   => $user,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to retrieve user profile',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

}
