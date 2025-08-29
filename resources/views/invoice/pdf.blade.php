<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>📚 ReadSphere - Invoice</h2>
    <p><strong>Invoice ID:</strong> #{{ $order->id }}</p>
    <p><strong>User:</strong> {{ $order->user->name }}</p>
    <p><strong>Email:</strong> {{ $order->user->email }}</p>
    <p><strong>Date:</strong> {{ $order->created_at->format('d M, Y') }}</p>

    <table>
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
                <td colspan="3"><strong>Grand Total After Discount:</strong></td>
                <td><strong>$ {{ number_format($order->amount, 2) }}</strong></td>

            </tr>
        </tbody>
    </table>
</body>
</html>
