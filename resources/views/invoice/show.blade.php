@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center">📚 ReadSphere - Invoice</h2>
        <p><strong>Invoice ID:</strong> #{{ $order->id }}</p>
        <p><strong>User:</strong> {{ $order->user->name }}</p>
        <p><strong>Email:</strong> {{ $order->user->email }}</p>
        <p><strong>Date:</strong> {{ $order->created_at->format('d M, Y') }}</p>

        <div class="order-summary">
            <h3>Order Summary</h3>
            <div>
                <div><strong>Subtotal:</strong> ${{ number_format($subtotal, 2) }}</div>
                
                <div style="color: green;">
                    <strong>Discount</strong> -${{ number_format($discountAmount, 2) }}
                </div>    
                <div><strong>Shipping:</strong> {{ $shipping }}</div>
                <div><strong>Tax (8%):</strong> ${{ number_format($tax, 2) }}</div>
                <div><strong>Total After Discount:</strong> ${{ number_format($order->amount, 2) }}</div>
            </div>
        </div>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Qty</th>
                    <th>Price ($)</th>
                    <th>Total ($)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->book->title }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
               
                <tr>
                    <td colspan="3" class="text-end"><strong>Grand Total After Discount:</strong></td>
                    <td><strong>$ {{ number_format($order->amount, 2) }}</strong></td>

                </tr>
            </tbody>
        </table>

        <div class="mt-4 text-center">
            <a href="{{ route('invoice.download', $order->id) }}" class="btn btn-primary">
                Download Invoice (PDF)
            </a>
        </div>
    </div>
</div>
@endsection
