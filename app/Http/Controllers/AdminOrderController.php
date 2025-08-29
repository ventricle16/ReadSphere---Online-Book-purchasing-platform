<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;


class AdminOrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.book'])
            ->orderBy('created_at', 'desc');


        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('product_name', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('payment_method', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }


        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }


        $orders = $query->paginate(20);


        // Get order statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();


        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'cancelledOrders'
        ));
    }


    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.orders.create', compact('users'));
    }


    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,completed,cancelled',
            'payment_method' => 'required|string|max:50'
        ]);


        $order = Order::create($validated);


        return redirect()->route('admin.orders.index')
            ->with('success', 'Order created successfully.');
    }


    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.book']);
        return view('admin.orders.show', compact('order'));
    }


    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        $users = User::all();
        $order->load('items.book');
        return view('admin.orders.edit', compact('order', 'users'));
    }


    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,completed,cancelled',
            'payment_method' => 'required|string|max:50'
        ]);


        $order->update($validated);


        return redirect()->route('admin.orders.index')
            ->with('success', 'Order updated successfully.');
    }


    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order)
    {
        // Delete related order items first
        $order->items()->delete();
        $order->delete();


        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }


    /**
     * Get order statistics for dashboard
     */
    public function getOrderStats()
    {
        return [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'recent' => Order::with('user')->orderBy('created_at', 'desc')->take(5)->get()
        ];
    }
}





