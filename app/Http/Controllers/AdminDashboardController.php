<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Order;
use App\Models\Category;
use App\Models\Payment;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Fetch data for the admin dashboard
        $totalBooks = Book::count();
        $totalEarnings = Payment::sum('amount');
        $totalTransactions = Payment::count();
        $totalCategories = Category::count();
        $totalStocks = Book::sum('stock');

        // Fetch recent books for display
        $books = Book::with('category')->latest()->paginate(12);

        // Pass data to the view
        return view('admin.dashboard', compact('totalBooks', 'totalEarnings', 'totalTransactions', 'totalCategories', 'totalStocks', 'books'));
    }
}
