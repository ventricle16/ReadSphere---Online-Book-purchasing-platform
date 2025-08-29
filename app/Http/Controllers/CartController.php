<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the user's shopping cart.
     */
    public function index()
    {
        $user = Auth::user();
        $cart = $user->getCart();
        $items = $cart->items()->with('book')->get();

        // Calculate total amount (from your friend's code)
        $total_amount = $this->calculateTotalAmount($cart);

        return view('cart', [
            'cart' => $cart,
            'items' => $items,
            'total_amount' => $total_amount
        ]);
    }

    /**
     * Add a book to the cart.
     */
    public function add(Request $request, $bookId)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1|max:10'
        ]);

        $book = Book::findOrFail($bookId);
        $user = Auth::user();
        $cart = $user->getCart();

        $quantity = $request->input('quantity', 1);

        // Added your try-catch block for better error handling
        try {
            $cart->addItem($book, $quantity);
            return redirect()->back()->with('success', 'Book added to cart successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update item quantity in cart.
     */
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $item = CartItem::findOrFail($itemId);
        
        // Verify the item belongs to the authenticated user
        if ($item->cart->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $item->updateQuantity($request->quantity);

        return redirect()->route('cart')->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart.
     */
    public function remove($itemId)
    {
        $item = CartItem::findOrFail($itemId);
        
        // Verify the item belongs to the authenticated user
        if ($item->cart->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $item->delete();
        $item->cart->refreshTotals();

        return redirect()->route('cart')->with('success', 'Item removed from cart!');
    }

    /**
     * Clear the entire cart.
     */
    public function clear()
    {
        $user = Auth::user();
        $cart = $user->getCart();
        $cart->clear();

        return redirect()->route('cart')->with('success', 'Cart cleared successfully!');
    }

    /**
     * Get cart item count for AJAX requests.
     */
    public function getCount()
    {
        $user = Auth::user();
        $cart = $user->getCart();
        
        return response()->json([
            'count' => $cart->item_count
        ]);
    }

    /**
     * Apply discount coupon to cart. (Your new function)
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        $user = Auth::user();
        $cart = $user->getCart();

        try {
            $cart->applyDiscount($request->coupon_code);
            return redirect()->route('cart')->with('success', 'Coupon applied successfully!');
        } catch (\Exception $e) {
            return redirect()->route('cart')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove discount coupon from cart. (Your new function)
     */
    public function removeCoupon()
    {
        $user = Auth::user();
        $cart = $user->getCart();
        $cart->removeDiscount();

        return redirect()->route('cart')->with('success', 'Coupon removed successfully!');
    }

    /**
     * Calculate total amount of the cart. (From your friend's code)
     */
    private function calculateTotalAmount($cart)
    {
        return $cart->items->sum(function ($item) {
            return $item->book->price * $item->quantity;
        });
    }
}



