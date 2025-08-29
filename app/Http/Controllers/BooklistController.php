<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BooklistController extends Controller
{
    public function index()
    {
        return Book::with('category')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);
        return Book::create($request->all());
    }

    public function show(Book $book)
    {
        return $book->load('category');
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'category_id' => 'exists:categories,id'
        ]);
        $book->update($request->all());
        return $book;
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(['message' => 'Book deleted']);
    }

    public function addToWishlist($id)
    {
        $user = Auth::user();
        $user->wishlist()->syncWithoutDetaching([$id]);
        return redirect()->back()->with('success','Book added to your wishlist!');
    }

}

    