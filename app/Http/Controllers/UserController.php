<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        // For demo, get the first user or create a default user object
        $user = User::first() ?? new User(['name' => 'Guest', 'bio' => 'No bio available']);
        return view('users.profile', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->only(['name', 'bio']));
        return redirect()->route('users.profile')->with('success', 'Profile updated successfully.');
    }

    public function wishlist()
    {
        $user = Auth::user();
        $books = $user->wishlist()->get();
        return view('users.wishlist',compact('books'));
    }
}

