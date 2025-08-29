@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2 class="text-success">🎉 Payment Successful!</h2>
    <p>Your order has been placed successfully.</p>
    <p>Thank you for your purchase at <strong>ReadSphere</strong>.</p>

    <div class="card mt-4">
        <div class="card-body">
            <h5>Order ID: {{ $order->id }}</h5>
            <p><strong>Name:</strong> {{ $order->customer_name }}</p>
            <p><strong>Mobile:</strong> {{ $order->customer_mobile }}</p>
            <p><strong>Total Paid:</strong> $ {{ number_format($finalAmount, 2) }}</p>
        </div>
    </div>
    {{-- Show Invoice --}}
        @if(session('order_id'))
            @php
                $orderId = session('order_id');
            @endphp
            <div class="mt-4">
                @include('invoice.show', ['order' => \App\Models\Order::with('items.book')->find($orderId)])
            </div>
        @endif
<a href="{{ route('invoice.show', $order->id) }}" class="btn btn-primary" style="background-color: blue; color: white;">View Invoice</a>
<a href="{{ route('invoice.download', $order->id) }}" class="btn btn-primary" style="background-color: blue; color: white;">Download Invoice</a>

<a href="{{ route('dashboard') }}" class="btn btn-primary mt-3" style="background-color: blue; color: white;">Go Back to Home</a>

</div>
@endsection
