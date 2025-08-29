@extends('layouts.app')


@section('title', 'Manage Orders')


@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Manage Orders</h1>


    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif


    <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search orders..." class="border rounded px-3 py-2 flex-grow" />
        <select name="status" class="border rounded px-3 py-2">
            <option value="">All Statuses</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
    </form>


    <table class="min-w-full bg-white border border-gray-200 rounded shadow">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="py-2 px-4 border-b">Order ID</th>
                <th class="py-2 px-4 border-b">User</th>
                <th class="py-2 px-4 border-b">Books Ordered</th>
                <th class="py-2 px-4 border-b">Total Amount</th>
                <th class="py-2 px-4 border-b">Status</th>
                <th class="py-2 px-4 border-b">Payment Method</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-2 px-4">{{ $order->id }}</td>
                <td class="py-2 px-4">{{ $order->user->name ?? 'N/A' }}</td>
                <td class="py-2 px-4">{{ $order->items->sum('quantity') }}</td>
                <td class="py-2 px-4">${{ number_format($order->total_amount, 2) }}</td>
                <td class="py-2 px-4 capitalize">{{ $order->status }}</td>
                <td class="py-2 px-4">{{ $order->payment_method }}</td>
                <td class="py-2 px-4">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:underline">View</a> |
                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-yellow-600 hover:underline">Edit</a> |
                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this order?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline bg-transparent border-none p-0 m-0 cursor-pointer">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-4 px-4 text-center text-gray-500">No orders found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>


    <div class="mt-4">
        {{ $orders->withQueryString()->links() }}
    </div>
</div>
@endsection



