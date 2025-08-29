<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')->where('user_id', Auth::id())->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:card,bkash,bank_transfer'
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_name' => $request->product_name,
            'total_amount' => $cart->final_total,
            'status' => 'pending',
            'payment_method' => $request->payment_method
        ]);

        return redirect()->route('orders.show', $order)->with('success', 'Order created successfully.');
    }
}


