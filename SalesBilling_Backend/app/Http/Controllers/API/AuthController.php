<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource; 
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Register a new user
    public function register(UserRequest $request)
    {
        $data = $request->validated();

        // Create user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);


      // Get role names from validated data
$roleNames = $data['roles'] ?? ['Cashier']; // default to Cashier

// Fetch the corresponding role IDs from the database
$roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
        
// Sync roles to the user
$user->roles()->sync($roleIds);

        // create token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'user' => new UserResource($user),
            'token' => $token,
            'token_type' => 'Bearer'
        ], 201);
    }

    // Login existing user
    public function login(Request $request)
    {
       $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Delete old tokens
        $user->tokens()->delete();

        // Create new token
        $token = $user->createToken('auth_token')->plainTextToken;


        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'user' => new UserResource($user),
            'token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    // Logout user
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}