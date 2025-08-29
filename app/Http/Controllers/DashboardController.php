<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function index(Request $request)
{
    // Get the search query
    $searchQuery = trim((string) $request->query('q', ''));
    $categoryId = $request->query('category');
    $rating = $request->query('ratings');

    // Start with all active books
    $booksQuery = Book::where('is_active', true);

    // Apply search filters
    if ($searchQuery !== '') {
        $booksQuery->where(function($query) use ($searchQuery) {
            $query->where('title', 'like', "%{$searchQuery}%")
                  ->orWhere('author', 'like', "%{$searchQuery}%")
                  ->orWhere('genre', 'like', "%{$searchQuery}%");
        });
    }

    // Apply category filter
    if ($categoryId) {
        $booksQuery->where('category_id', $categoryId);
    }

    // Apply rating filter
    if ($rating) {
        $booksQuery->where('rating', $rating);
    }

    // Get the books with pagination
    $books = $booksQuery->orderBy('created_at', 'desc')->paginate(12);

    return view('dashboard', [
        'books' => $books,
        'q' => $searchQuery,
        'categories' => Category::all(), // Ensure categories are passed to the view
    ]);
}
    public function __invoke()
    {
        return view('dashboard');
    }

}
