@extends('layouts.app')


@section('title', 'Edit Order')


@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Edit Order #{{ $order->id }}</h1>


    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
       
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-semibold mb-3">Order Information</h2>
                <div class="space-y-4">
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700">User</label>
                        <select name="user_id" id="user_id" class="mt-1 block w-full border rounded px-3 py-2" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $order->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                   
                    <div>
                        <label for="product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input type="text" name="product_name" id="product_name"
                               value="{{ old('product_name', $order->product_name) }}"
                               class="mt-1 block w-full border rounded px-3 py-2" required>
                    </div>
                   
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Total Amount</label>
                        <input type="number" name="amount" id="amount" step="0.01"
                               value="{{ old('amount', $order->amount) }}"
                               class="mt-1 block w-full border rounded px-3 py-2" required>
                    </div>
                   
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full border rounded px-3 py-2" required>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                   
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                        <input type="text" name="payment_method" id="payment_method"
                               value="{{ old('payment_method', $order->payment_method) }}"
                               class="mt-1 block w-full border rounded px-3 py-2" required>
                    </div>
                </div>
            </div>


            <div class="bg-white p-4 rounded shadow">
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
        </div>


        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Order</button>
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Cancel</a>
        </div>
    </form>
</div>
@endsection



