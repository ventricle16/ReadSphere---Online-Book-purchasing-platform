<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Cart;
use App\Models\Book;
use App\Models\OrderItem;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function show()
    {
        $user = Auth::user();
        $cart = $user->getCart();
        $items = $cart->items()->with('book')->get();

        if ($cart->item_count === 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        return view('checkout', [
            'cart' => $cart,
            'items' => $items,
            'user' => $user
        ]);
    }

    /**
     * Process the checkout and create order.
     */
    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:card,bkash,bank_transfer',
            'shipping_address' => 'required|string|max:500',
            'billing_address' => 'required|string|max:500',
        ]);

        $user = Auth::user();
        $cart = $user->getCart();

        if ($cart->item_count === 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }
        // Use discounted total if available
        $cart->refreshTotals();
        $finalAmount = $cart->discount_amount > 0 ? $cart->final_total : $cart->total_amount * 1.08;

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'product_name' => $cart->item_count . ' Book(s)',
            'amount' => $cart->final_total,
            'status' => 'pending',
            'payment_method' => $request->payment_method
            ]);

        // Add order items
        foreach ($cart->items as $item) {
            $order->items()->create([
                'book_id' => $item->book_id,
                'quantity' => $item->quantity,
                'price' => $item->book->price,
                'subtotal' => $item->quantity * $item->book->price
            ]);
        }
        
        // Create invoice
        // $invoice = Invoice::create([
        //     'order_id' => $order->id,
        //     'user_id' => $user->id,
        //     'amount' => $cart->total_amount * 1.08,
        //     'status' => 'pending',
        //     'payment_method' => $request->payment_method,
        //     'shipping_address' => $request->shipping_address,
        //     'billing_address' => $request->billing_address,
        // ]);
        
        // Create payment record
        //$total = $cart->calculateTotalAmount();
        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $cart->final_total,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        // Handle payment method redirection
        if ($request->payment_method === 'card') {
            return redirect()->route('stripe.view', $order->id);
        } elseif ($request->payment_method === 'bkash') {
            return redirect()->route('bkash.pay', $invoice->id);
        } else {
            // Bank transfer - show confirmation page
            return view('checkout.confirmation', compact('order'));
        }
    }
    public function createPaymentIntent(Request $request) {
        // Called via AJAX from checkout page
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        // compute total again for security
        $total = 0;
        $items = [];

        if (auth()->check()) {
            $cart = Cart::firstOrCreate(['user_id'=>auth()->id()]);
            $cartItems = $cart->items()->with('book')->get();
            foreach($cartItems as $it) {
                $items[] = $it;
                $total += $it->book->price * $it->quantity;
            }
        } else {
            $sessionCart = session()->get('cart', []);
            foreach($sessionCart as $bookId=>$qty) {
                $book = Book::find($bookId);
                if ($book) { $items[] = (object)['book'=>$book,'quantity'=>$qty]; $total += $book->price * $qty; }
            }
        }

        if ($total <= 0) return response()->json(['error'=>'Cart empty'], 400);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        // create order record (pending)
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'amount' => $total * 100, // Stripe expects the amount in cents
            'currency' => 'usd', // Ensure currency is set to USD
            'product_name' => count($items) . ' Book(s)'
        ]);

        foreach ($items as $it) {
            $book = $it->book;
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $book->id,
                'quantity' => $it->quantity,
                'unit_price' => $book->price
            ]);
        }

        \Log::info('Total amount for payment: ' . $total * 100); // Log the total amount in cents
        $paymentIntent = PaymentIntent::create([
            'amount' => $total * 100, // Stripe expects the amount in cents
            'currency' => 'usd',
            'metadata' => [
                'order_id' => $order->id,
            ],
            'automatic_payment_methods' => ['enabled' => true],
        ]);

        // store payment intent id in order
        $order->stripe_payment_intent_id = $paymentIntent->id;
        $order->save();

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
            'orderId' => $order->id,
        ]);
    }

    public function paymentSuccess(Request $request) {
        $orderId = $request->order_id;
        $order = Order::find($orderId);
        if (!$order) return redirect('/')->with('error', 'Order not found');

        // clear cart
        if (auth()->check()) {
            $cart = Cart::firstOrCreate(['user_id'=>auth()->id()]);
            $cart->items()->delete();
        } else {
            session()->forget('cart');
        }

        

        return view('checkout.success', compact('order'));
        session()->flash('order_id', $order->id);
        return redirect()->route('stripe.success');
    }

    /**
     * Show order confirmation.
     */
    public function confirmation($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('checkout.confirmation', [
            'order' => $order
        ]);
    }
    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        $cart = $user->getCart();

        if (!$cart || $cart->items()->count() === 0) {
            return back()->with('error', 'Your cart is empty.');
        }

        // ✅ Copy cart total into order->amount
        $order = Order::create([
            'user_id'        => $user->id,
            'product_name'   => 'Books Purchase',
            'amount'         => $cart->final_total,  // << this must not be zero
            'status'         => 'pending',
            'payment_method' => 'card'
        ]);

        foreach ($cart->items as $cartItem) {
            $order->items()->create([
                'book_id'   => $cartItem->book_id,
                'quantity'  => $cartItem->quantity,
                'price'     => $cartItem->price,
                'subtotal'  => $cartItem->subtotal,
            ]);
        }

        $cart->clear();

        return redirect()->route('stripe.view', $order->id);
    }

}
