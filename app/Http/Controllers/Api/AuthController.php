<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Models\AppUsers;
use App\Models\UserVerification;

class AuthController extends Controller
{

    // Register Method for appusers
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:appUser',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required|in:male,female,other',
            'user_type' => 'required|in:student,professional',
        ]);

        AppUsers::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'gender' => $request->gender,
            'user_type' => $request->user_type,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful. Please log in.',
        ], 201);

    }



    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);


        if (!$token = Auth::guard('api')->attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }

        $user = Auth::guard('api')->user();

        $verifications = UserVerification::where('user_id', $user->id)
            ->orderByDesc('id')
            ->get()
            ->unique('type')
            ->pluck('status', 'type');

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => Auth::guard('api')->user(),
            'verification_status' => $verifications,
        ]);
    }


}
