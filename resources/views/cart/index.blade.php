<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>??</text></svg>">
    <title>My Cart - BookMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#0a0a0f; color:#fff; min-height:100vh; }

        /* Navbar */
        .navbar { position:sticky; top:0; z-index:100; background:rgba(10,10,15,0.95); backdrop-filter:blur(20px); border-bottom:1px solid rgba(255,255,255,0.06); padding:14px 32px; display:flex; justify-content:space-between; align-items:center; }
        .nav-brand { display:flex; align-items:center; gap:10px; text-decoration:none; }
        .nav-brand-icon { width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,#7c3aed,#4f46e5); display:flex; align-items:center; justify-content:center; font-size:16px; }
        .nav-brand-name { font-size:18px; font-weight:900; color:#fff; }
        .nav-brand-name span { background:linear-gradient(135deg,#a78bfa,#60a5fa); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .nav-links { display:flex; align-items:center; gap:8px; }
        .nav-link { padding:8px 16px; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600; color:rgba(255,255,255,0.6); transition:all 0.2s; }
        .nav-link:hover { background:rgba(255,255,255,0.06); color:#fff; }
        .nav-link.active { background:rgba(124,58,237,0.2); color:#a78bfa; }
        .btn-logout { padding:8px 16px; border-radius:8px; border:none; background:rgba(239,68,68,0.1); color:#f87171; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .btn-logout:hover { background:rgba(239,68,68,0.2); }

        /* Page */
        .page { max-width:1000px; margin:0 auto; padding:36px 24px; }
        .page-header { margin-bottom:28px; }
        .page-header h1 { font-size:28px; font-weight:800; }
        .page-header p { color:rgba(255,255,255,0.4); font-size:14px; margin-top:4px; }

        /* Alerts */
        .alert { padding:12px 18px; border-radius:12px; margin-bottom:20px; font-size:14px; display:flex; align-items:center; gap:8px; }
        .alert-success { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#6ee7b7; }
        .alert-error { background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#fca5a5; }

        /* Layout */
        .cart-layout { display:grid; grid-template-columns:1fr 340px; gap:24px; }
        @media(max-width:768px) { .cart-layout { grid-template-columns:1fr; } }

        /* Cart Items */
        .cart-items { }
        .cart-item { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:16px; padding:18px 20px; margin-bottom:12px; display:flex; align-items:center; gap:16px; transition:all 0.2s; }
        .cart-item:hover { border-color:rgba(255,255,255,0.12); }
        .cart-img { width:64px; height:80px; object-fit:cover; border-radius:8px; flex-shrink:0; }
        .cart-placeholder { width:64px; height:80px; border-radius:8px; background:linear-gradient(135deg,rgba(124,58,237,0.2),rgba(168,85,247,0.1)); display:flex; align-items:center; justify-content:center; font-size:24px; flex-shrink:0; }
        .cart-info { flex:1; min-width:0; }
        .cart-title { font-size:15px; font-weight:700; margin-bottom:3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .cart-author { font-size:13px; color:rgba(255,255,255,0.4); margin-bottom:6px; }
        .cart-price { font-size:18px; font-weight:800; background:linear-gradient(135deg,#a78bfa,#f472b6); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .cart-remove { padding:8px 14px; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#f87171; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; flex-shrink:0; }
        .cart-remove:hover { background:rgba(239,68,68,0.2); }

        /* Clear Cart */
        .clear-btn { padding:10px 18px; background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.15); color:#f87171; border-radius:10px; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; margin-bottom:16px; }
        .clear-btn:hover { background:rgba(239,68,68,0.15); }

        /* Summary Card */
        .summary-card { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:16px; padding:24px; position:sticky; top:80px; }
        .summary-title { font-size:16px; font-weight:700; margin-bottom:20px; padding-bottom:14px; border-bottom:1px solid rgba(255,255,255,0.06); }

        /* Coupon */
        .coupon-section { margin-bottom:20px; padding-bottom:20px; border-bottom:1px solid rgba(255,255,255,0.06); }
        .coupon-title { font-size:13px; font-weight:600; color:rgba(255,255,255,0.5); margin-bottom:10px; text-transform:uppercase; letter-spacing:0.5px; }
        .coupon-applied { background:rgba(52,211,153,0.08); border:1px solid rgba(52,211,153,0.2); border-radius:10px; padding:10px 14px; margin-bottom:10px; display:flex; justify-content:space-between; align-items:center; }
        .coupon-applied-text { font-size:13px; color:#6ee7b7; font-weight:600; }
        .coupon-remove { background:none; border:none; color:#f87171; font-size:12px; cursor:pointer; font-family:'Inter',sans-serif; font-weight:600; }
        .coupon-row { display:flex; gap:8px; }
        .coupon-input { flex:1; padding:10px 12px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08); border-radius:8px; color:#fff; font-size:13px; font-family:'Inter',sans-serif; outline:none; transition:all 0.3s; }
        .coupon-input:focus { border-color:rgba(124,58,237,0.5); }
        .coupon-input::placeholder { color:rgba(255,255,255,0.2); }
        .coupon-btn { padding:10px 16px; background:rgba(124,58,237,0.15); border:1px solid rgba(124,58,237,0.3); color:#a78bfa; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; white-space:nowrap; }
        .coupon-btn:hover { background:rgba(124,58,237,0.25); }

        /* Price Breakdown */
        .price-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
        .price-label { font-size:14px; color:rgba(255,255,255,0.5); }
        .price-value { font-size:14px; font-weight:600; }
        .price-discount { color:#6ee7b7; }
        .price-total-row { display:flex; justify-content:space-between; align-items:center; margin-top:14px; padding-top:14px; border-top:1px solid rgba(255,255,255,0.08); }
        .price-total-label { font-size:16px; font-weight:700; }
        .price-total-value { font-size:24px; font-weight:900; background:linear-gradient(135deg,#a78bfa,#f472b6); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }

        /* Checkout Btn */
        .btn-checkout { display:block; width:100%; padding:15px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; border:none; border-radius:12px; font-size:15px; font-weight:800; cursor:pointer; font-family:'Inter',sans-serif; text-decoration:none; text-align:center; margin-top:20px; transition:all 0.3s; box-shadow:0 6px 25px rgba(124,58,237,0.35); }
        .btn-checkout:hover { transform:translateY(-2px); box-shadow:0 10px 35px rgba(124,58,237,0.55); }

        /* Address selector */
        .address-selector { margin-bottom:16px; }
        .address-selector-title { font-size:13px; font-weight:600; color:rgba(255,255,255,0.5); margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px; }
        .address-option { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:10px; padding:10px 14px; margin-bottom:6px; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; gap:10px; }
        .address-option:hover { border-color:rgba(124,58,237,0.3); }
        .address-option.selected { border-color:rgba(124,58,237,0.5); background:rgba(124,58,237,0.08); }
        .address-option-text { font-size:12px; color:rgba(255,255,255,0.6); line-height:1.4; }
        .address-option-name { font-size:13px; font-weight:700; color:#fff; }

        /* Security note */
        .security-note { text-align:center; font-size:11px; color:rgba(255,255,255,0.25); margin-top:12px; }

        /* Empty */
        .empty-state { text-align:center; padding:80px 20px; }
        .empty-icon { font-size:64px; margin-bottom:16px; }
        .empty-title { font-size:20px; font-weight:700; margin-bottom:8px; }
        .empty-sub { font-size:14px; color:rgba(255,255,255,0.4); margin-bottom:24px; }
        .btn-browse { padding:12px 28px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; border-radius:12px; text-decoration:none; font-weight:700; font-size:14px; transition:all 0.2s; display:inline-block; }
        .btn-browse:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(124,58,237,0.4); }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <a href="{{ route('home') }}" class="nav-brand">
        <div class="nav-brand-icon">📚</div>
        <div class="nav-brand-name">Book<span>Mart</span></div>
    </a>
    <div class="nav-links">
        <a href="{{ route('buyer.dashboard') }}" class="nav-link">Dashboard</a>
        <a href="{{ route('books.index') }}" class="nav-link">Browse Books</a>
        <a href="{{ route('cart.index') }}" class="nav-link active">🛒 Cart</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
</nav>

<div class="page">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif

    <div class="page-header">
        <h1>🛒 My Cart</h1>
        <p>{{ count($cart) }}টি book cart এ আছে</p>
    </div>

    @if(empty($cart))
        <div class="empty-state">
            <div class="empty-icon">🛒</div>
            <div class="empty-title">Cart খালি</div>
            <div class="empty-sub">কোনো book cart এ নেই</div>
            <a href="{{ route('books.index') }}" class="btn-browse">📚 Browse Books</a>
        </div>
    @else
        <div class="cart-layout">

            {{-- Left: Cart Items --}}
            <div>
                {{-- Clear Cart --}}
                <form method="POST" action="{{ route('cart.clear') }}" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="clear-btn"
                            onclick="return confirm('Cart সম্পূর্ণ খালি করবেন?')">
                        🗑️ Clear All
                    </button>
                </form>

                @foreach($cart as $item)
                    <div class="cart-item">
                        @if($item['image'])
                            <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['title'] }}" class="cart-img">
                        @else
                            <div class="cart-placeholder">📚</div>
                        @endif

                        <div class="cart-info">
                            <div class="cart-title">{{ $item['title'] }}</div>
                            <div class="cart-author">by {{ $item['author'] }}</div>
                            <div class="cart-price">৳{{ number_format($item['price'], 0) }}</div>
                        </div>

                        <form method="POST" action="{{ route('cart.remove', $item['id']) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="cart-remove">✕ Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>

            {{-- Right: Summary --}}
            <div class="summary-card">
                <div class="summary-title">📋 Order Summary</div>

                {{-- Coupon --}}
                <div class="coupon-section">
                    <div class="coupon-title">🎟️ Coupon Code</div>

                    @if(session('coupon'))
                        <div class="coupon-applied">
                            <span class="coupon-applied-text">✅ {{ session('coupon.code') }} — ৳{{ session('coupon.discount') }} off</span>
                            <form method="POST" action="{{ route('coupon.remove') }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="coupon-remove">✕</button>
                            </form>
                        </div>
                    @else
                        <form method="POST" action="{{ route('coupon.apply') }}" class="coupon-row">
                            @csrf
                            <input type="text" name="coupon_code" class="coupon-input" placeholder="Coupon code...">
                            <button type="submit" class="coupon-btn">Apply</button>
                        </form>
                        @if(session('coupon_error'))
                            <div style="font-size:12px; color:#f87171; margin-top:6px;">❌ {{ session('coupon_error') }}</div>
                        @endif
                    @endif
                </div>

                {{-- Price Breakdown --}}
                @php $discount = session('coupon.discount') ?? 0; $finalTotal = $total - $discount; @endphp

                @foreach($cart as $item)
                    <div class="price-row">
                        <span class="price-label" style="font-size:12px;">{{ Str::limit($item['title'], 25) }}</span>
                        <span class="price-value" style="font-size:13px;">৳{{ number_format($item['price'], 0) }}</span>
                    </div>
                @endforeach

                <div class="price-row" style="margin-top:10px; padding-top:10px; border-top:1px solid rgba(255,255,255,0.05);">
                    <span class="price-label">Subtotal</span>
                    <span class="price-value">৳{{ number_format($total, 0) }}</span>
                </div>

                @if($discount > 0)
                    <div class="price-row">
                        <span class="price-label">Discount</span>
                        <span class="price-value price-discount">- ৳{{ number_format($discount, 0) }}</span>
                    </div>
                @endif

                <div class="price-row">
                    <span class="price-label">Delivery</span>
                    <span class="price-value" style="color:#6ee7b7;">Free</span>
                </div>

                <div class="price-total-row">
                    <span class="price-total-label">Total</span>
                    <span class="price-total-value">৳{{ number_format($finalTotal, 0) }}</span>
                </div>

                <a href="{{ route('orders.checkout') }}" class="btn-checkout">
                    🚀 Proceed to Checkout
                </a>

                <div class="security-note">🔒 256-bit SSL Encrypted · 100% Secure</div>
            </div>
        </div>
    @endif
</div>

</body>
</html>