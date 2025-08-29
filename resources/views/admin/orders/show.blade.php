@extends('layouts.app')


@section('title', 'Order Details')


@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Order Details #{{ $order->id }}</h1>


    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-3">Order Information</h2>
            <div class="space-y-2">
                <p><strong>Order ID:</strong> {{ $order->id }}</p>
                <p><strong>Status:</strong> <span class="capitalize">{{ $order->status }}</span></p>
                <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                <p><strong>Created At:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                <p><strong>Updated At:</strong> {{ $order->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>


        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-3">Customer Information</h2>
            <div class="space-y-2">
                <p><strong>User ID:</strong> {{ $order->user_id }}</p>
                <p><strong>Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
            </div>
        </div>
    </div>


    <div class="bg-white p-4 rounded shadow mb-6">
        <h2 class="text-lg font-semibold mb-3">Order Items</h2>
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 text-left">Book</th>
                    <th class="py-2 px-4 text-left">Quantity</th>
                    <th class="py-2 px-4 text-left">Price</th>
                    <th class="py-2 px-4 text-left">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $item->book->title ?? 'Book not found' }}</td>
                    <td class="py-2 px-4">{{ $item->quantity }}</td>
                    <td class="py-2 px-4">${{ number_format($item->price, 2) }}</td>
                    <td class="py-2 px-4">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
                <tr class="font-semibold">
                    <td colspan="3" class="py-2 px-4 text-right">Total:</td>
                    <td class="py-2 px-4">${{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>


    <div class="flex gap-2">
        <a href="{{ route('admin.orders.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Back to Orders</a>
        <a href="{{ route('admin.orders.edit', $order->id) }}" class="bg-yellow-600 text-white px-4 py-2 rounded">Edit Order</a>
    </div>
</div>
@endsection





