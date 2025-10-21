<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();

        // Handle error
        if ($users->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No users found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => UserResource::collection($users)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('roles')->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => new UserResource($user)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $user = User::with('roles')->findOrFail($id);

    $data = $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|max:255|unique:users,email,' . $user->id,
        'password' => 'sometimes|string|min:6',
        'roles' => 'sometimes|array',
        'roles.*' => 'exists:roles,name', 
    ]);

    // Only update password when provided (and hash it)
    if (isset($data['password']) && $data['password'] !== null && $data['password'] !== '') {
        $data['password'] = Hash::make($data['password']);
    } else {
        unset($data['password']); // prevent overwriting existing password with null
    }

    // Update user fields (name, email, password)
    $user->update($data);

    // Sync roles by name if provided
    if (array_key_exists('roles', $data)) {
        $roleIds = \App\Models\Role::whereIn('name', $data['roles'])->pluck('id')->toArray();
        $user->roles()->sync($roleIds);
    }

    // Reload user to get the updated relationships
    $user->load('roles');

    return response()->json([
        'status' => true,
        'data' => new UserResource($user)
    ]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::with('roles')->findOrFail($id);

        // Detach roles first (optional because ON DELETE CASCADE on pivot may handle it)
        $user->roles()->detach();

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}