<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>??</text></svg>">
    <title>Invoice - BookMart</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #4f46e5; font-size: 28px; }
        .header p { color: #666; }
        .invoice-info { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .invoice-info div { width: 48%; }
        .invoice-info h3 { color: #4f46e5; border-bottom: 2px solid #4f46e5; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table th { background: #4f46e5; color: white; padding: 10px; text-align: left; }
        table td { padding: 10px; border-bottom: 1px solid #eee; }
        .total { text-align: right; font-size: 20px; font-weight: bold; color: #4f46e5; }
        .footer { text-align: center; color: #999; font-size: 12px; margin-top: 40px; }
        .status { background: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 20px; }
    </style>
</head>
<body>

<div class="header">
    <h1>📚 BookMart</h1>
    <p>Book Buy & Sell Platform</p>
    <p>Invoice</p>
</div>

<div class="invoice-info">
    <div>
        <h3>Invoice Details</h3>
        <p><strong>Invoice #:</strong> INV-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
        <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
        <p><strong>Status:</strong> <span class="status">{{ ucfirst($order->status) }}</span></p>
    </div>
    <div>
        <h3>Buyer Details</h3>
        <p><strong>Name:</strong> {{ $order->buyer->name }}</p>
        <p><strong>Email:</strong> {{ $order->buyer->email }}</p>
        <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Book Title</th>
            <th>Author</th>
            <th>Seller</th>
            <th>Condition</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>{{ $order->book->title }}</td>
            <td>{{ $order->book->author }}</td>
            <td>{{ $order->book->seller->name }}</td>
            <td>{{ ucfirst($order->book->condition) }}</td>
            <td>৳{{ $order->price }}</td>
        </tr>
    </tbody>
</table>

<div class="total">
    Total Amount: ৳{{ $order->price }}
</div>

<div class="footer">
    <p>Thank you for shopping with BookMart!</p>
    <p>Generated on {{ now()->format('d M Y h:i A') }}</p>
</div>

</body>
</html>