<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0; }
        .container { max-width:600px; margin:30px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.1); }
        .header { background:linear-gradient(135deg,#7c3aed,#4f46e5); padding:32px; text-align:center; }
        .header h1 { color:#fff; margin:0; font-size:24px; }
        .header p { color:rgba(255,255,255,0.8); margin:8px 0 0; }
        .body { padding:32px; }
        .greeting { font-size:18px; font-weight:700; color:#1a1a2e; margin-bottom:16px; }
        .info-box { background:#f8f4ff; border:1px solid #e9d5ff; border-radius:10px; padding:20px; margin:20px 0; }
        .info-row { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #e9d5ff; }
        .info-row:last-child { border-bottom:none; }
        .info-label { color:#6b7280; font-size:14px; }
        .info-value { color:#1a1a2e; font-weight:700; font-size:14px; }
        .price { color:#7c3aed; font-size:20px; font-weight:900; }
        .btn { display:block; width:fit-content; margin:24px auto; padding:14px 32px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; text-decoration:none; border-radius:10px; font-weight:700; font-size:15px; }
        .footer { background:#f8f4ff; padding:20px; text-align:center; color:#9ca3af; font-size:12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 BookMart</h1>
            <p>Your order has been confirmed!</p>
        </div>
        <div class="body">
            <div class="greeting">Hi {{ $order->buyer->name }}! 👋</div>
            <p style="color:#6b7280;">Great news! Your payment was successful and your order is confirmed.</p>
            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Order ID</span>
                    <span class="info-value">#{{ $order->id }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Book</span>
                    <span class="info-value">{{ $order->book->title }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Author</span>
                    <span class="info-value">{{ $order->book->author }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Amount Paid</span>
                    <span class="info-value price">৳{{ number_format($order->price, 0) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value" style="color:#34d399;">✅ Confirmed</span>
                </div>
            </div>
            <p style="color:#6b7280; font-size:14px;">The seller will contact you soon for delivery. Thank you for shopping on BookMart!</p>
            <a href="{{ url("/my-orders") }}" class="btn">📦 View My Orders</a>
        </div>
        <div class="footer">
            © {{ date("Y") }} BookMart. Bangladesh'"'"'s #1 Book Marketplace.<br>
            Made with ❤️ in Bangladesh
        </div>
    </div>
</body>
</html>'