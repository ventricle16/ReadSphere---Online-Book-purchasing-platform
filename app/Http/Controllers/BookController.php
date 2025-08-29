<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // Only active books
        $query->where('is_active', true);

        // Category filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Rating filter
        if ($request->has('rating') && $request->rating != '') {
            $query->where('rating', '>=', $request->rating);
        }

        // Fetch books
        $books = $query->orderBy('created_at', 'desc')->paginate(12);

        // Fetch categories for dropdown
        $categories = Category::all();

        return view('books.index', compact('books', 'categories'));
    }

    // API: return books with category + rating filter
    public function apiBooks(Request $request)
    {
        $query = Book::with('category');

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('rating') && $request->rating != '') {
            $query->where('rating', '>=', $request->rating);
        }

        return response()->json($query->get());
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        
        // Fetch related books based on genre or author
        $relatedBooks = Book::where('id', '!=', $id)
            ->where(function($query) use ($book) {
                $query->where('genre', $book->genre)
                      ->orWhere('author', $book->author);
            })
            ->take(5)
            ->get();

        return view('books.show', compact('book', 'relatedBooks'));
    }
    public function addToWishlist(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $user = $request->user(); // Get the authenticated user


        // Check if book already exists in wishlist
        if ($user->wishlist()->where('book_id', $book->id)->exists()) {
            return redirect()->back()->with('info', 'This book is already in your wishlist!');
        }


        // Add the book to the user's wishlist
        $user->wishlist()->attach($book->id);


        return redirect()->back()->with('success', 'Book added to your wishlist!');
    }
}
