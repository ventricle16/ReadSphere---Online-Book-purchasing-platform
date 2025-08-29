<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // GET /api/users/{id}
    public function show($id): JsonResponse
    {
        $user = User::with('wishlist')->find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    // PUT /api/users/{id}
    public function update(Request $request, $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) return response()->json(['error' => 'User not found'], 404);

        $data = $request->only(['name','bio','profile_picture','email']);

        $validated = $request->validate([
            'name' => ['nullable','string','max:255'],
            'bio' => ['nullable','string'],
            'profile_picture' => ['nullable','string','max:1000'],
            'email' => ['nullable','email', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update(array_filter($validated, fn($v) => !is_null($v)));

        return response()->json(['success' => 'User profile updated successfully', 'user' => $user]);
    }
}