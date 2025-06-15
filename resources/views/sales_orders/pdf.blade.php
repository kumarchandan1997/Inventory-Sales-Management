<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Order PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Sales Order #{{ $order->id }}</h2>
    <p>Date: {{ $order->created_at->format('d M Y') }}</p>
    <p>Total: ₹{{ number_format($order->total_amount, 2) }}</p>

    <h4>Items:</h4>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₹{{ $item->price }}</td>
                <td>₹{{ $item->price * $item->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
