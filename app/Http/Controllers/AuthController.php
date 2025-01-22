<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'role' => 'required|string|in:siswa,admin_stan',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $existingUser = User::where('username', $request->username)->first();
        if ($existingUser && Hash::check($request->password, $existingUser->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Username and password already exist'
            ], 400);
        }
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    // login
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'message' => 'Successfully logged in',
            'token' => $token,
        ]);
    }

    // logout
    public function logout()
    {
        $user = JWTAuth::parseToken()->authenticate();

        JWTAuth::invalidate(JWTAuth::getToken());

        if ($user) {
            $user->delete();
        };

        return response()->json(['message' => 'Successfully logged out and user deleted']);
    }

}
