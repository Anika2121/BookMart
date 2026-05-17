<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0; }
        .container { max-width:600px; margin:30px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.1); }
        .header { background:linear-gradient(135deg,#dc2626,#f97316); padding:32px; text-align:center; }
        .header h1 { color:#fff; margin:0; font-size:24px; }
        .header p { color:rgba(255,255,255,0.8); margin:8px 0 0; }
        .body { padding:32px; }
        .greeting { font-size:18px; font-weight:700; color:#1a1a2e; margin-bottom:16px; }
        .info-box { background:#fff7ed; border:1px solid #fed7aa; border-radius:10px; padding:20px; margin:20px 0; }
        .info-row { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #fed7aa; }
        .info-row:last-child { border-bottom:none; }
        .info-label { color:#6b7280; font-size:14px; }
        .info-value { color:#1a1a2e; font-weight:700; font-size:14px; }
        .old-price { color:#9ca3af; text-decoration:line-through; font-size:16px; }
        .new-price { color:#dc2626; font-size:24px; font-weight:900; }
        .btn { display:block; width:fit-content; margin:24px auto; padding:14px 32px; background:linear-gradient(135deg,#dc2626,#f97316); color:#fff; text-decoration:none; border-radius:10px; font-weight:700; font-size:15px; }
        .footer { background:#fff7ed; padding:20px; text-align:center; color:#9ca3af; font-size:12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 BookMart</h1>
            <p>Price dropped on your wishlist book!</p>
        </div>
        <div class="body">
            <div class="greeting">Hi {{ $user->name }}! 📉</div>
            <p style="color:#6b7280;">Good news! A book in your wishlist just got cheaper. Grab it before it sells out!</p>
            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Book</span>
                    <span class="info-value">{{ $book->title }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Author</span>
                    <span class="info-value">{{ $book->author }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Old Price</span>
                    <span class="info-value old-price">৳{{ number_format($oldPrice, 0) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">New Price</span>
                    <span class="info-value new-price">৳{{ number_format($book->price, 0) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">You Save</span>
                    <span class="info-value" style="color:#16a34a;">৳{{ number_format($oldPrice - $book->price, 0) }}</span>
                </div>
            </div>
            <p style="color:#6b7280; font-size:14px;">Hurry! This book might sell out soon.</p>
            <a href="{{ url('/books/' . $book->id) }}" class="btn">🛒 Buy Now</a>
        </div>
        <div class="footer">
            © {{ date('Y') }} BookMart. Bangladesh's #1 Book Marketplace.<br>
            Made with ❤️ in Bangladesh
        </div>
    </div>
</body>
</html>
