<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class WishlistController extends Controller
{
    /**
     * Display the user's wishlist
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $books = $user->wishlist()->with('category')->paginate(12);
       
        return view('wishlist', compact('books'));
    }


    /**
     * Add a book to the user's wishlist
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Book $book)
    {
        $user = Auth::user();
       
        if ($user->wishlist()->where('book_id', $book->id)->exists()) {
            return redirect()->back()->with('info', 'This book is already in your wishlist!');
        }
       
        $user->wishlist()->attach($book->id);
       
        return redirect()->back()->with('success', 'Book added to your wishlist!');
    }


    /**
     * Remove a book from the user's wishlist
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Book $book)
    {
        $user = Auth::user();
        $user->wishlist()->detach($book->id);
       
        return redirect()->back()->with('success', 'Book removed from your wishlist!');
    }


    /**
     * Toggle a book in the user's wishlist
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(Book $book)
    {
        $user = Auth::user();
       
        if ($user->wishlist()->where('book_id', $book->id)->exists()) {
            $user->wishlist()->detach($book->id);
            return redirect()->back()->with('success', 'Book removed from your wishlist!');
        } else {
            $user->wishlist()->attach($book->id);
            return redirect()->back()->with('success', 'Book added to your wishlist!');
        }
    }


    /**
     * Display a specific user's wishlist
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function userWishlist(User $user)
    {
        $books = $user->wishlist()->with('category')->paginate(12);
       
        return view('wishlist', compact('books'));
    }
   
}









