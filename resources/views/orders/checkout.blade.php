<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>??</text></svg>">
    <title>Checkout - BookMart</title>
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
        .btn-logout { padding:8px 16px; border-radius:8px; border:none; background:rgba(239,68,68,0.1); color:#f87171; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .btn-logout:hover { background:rgba(239,68,68,0.2); }

        /* Progress Steps */
        .checkout-steps { max-width:600px; margin:24px auto; display:flex; align-items:center; padding:0 24px; }
        .step { display:flex; flex-direction:column; align-items:center; flex:1; position:relative; }
        .step::before { content:''; position:absolute; top:16px; left:-50%; width:100%; height:2px; background:rgba(255,255,255,0.08); z-index:0; }
        .step:first-child::before { display:none; }
        .step-dot { width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; position:relative; z-index:1; transition:all 0.3s; }
        .step-dot.done { background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; }
        .step-dot.active { background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; box-shadow:0 0 15px rgba(124,58,237,0.5); }
        .step-dot.pending { background:rgba(255,255,255,0.08); color:rgba(255,255,255,0.3); border:2px solid rgba(255,255,255,0.1); }
        .step-label { font-size:11px; color:rgba(255,255,255,0.4); margin-top:6px; font-weight:600; }
        .step-label.active { color:#a78bfa; }

        /* Page */
        .page { max-width:1000px; margin:0 auto; padding:24px; }

        /* Layout */
        .checkout-layout { display:grid; grid-template-columns:1fr 360px; gap:24px; }
        @media(max-width:768px) { .checkout-layout { grid-template-columns:1fr; } }

        /* Cards */
        .card { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:16px; padding:24px; margin-bottom:16px; }
        .card-title { font-size:15px; font-weight:700; margin-bottom:20px; display:flex; align-items:center; gap:8px; padding-bottom:14px; border-bottom:1px solid rgba(255,255,255,0.06); }

        /* Form Fields */
        .field { margin-bottom:14px; }
        .field-label { display:block; font-size:12px; font-weight:600; color:rgba(255,255,255,0.5); margin-bottom:7px; text-transform:uppercase; letter-spacing:0.5px; }
        .field-input { width:100%; padding:11px 14px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08); border-radius:10px; color:#fff; font-size:14px; font-family:'Inter',sans-serif; outline:none; transition:all 0.3s; }
        .field-input:focus { border-color:rgba(124,58,237,0.6); background:rgba(124,58,237,0.06); box-shadow:0 0 0 3px rgba(124,58,237,0.12); }
        .field-input:disabled { opacity:0.4; cursor:not-allowed; }
        .field-input::placeholder { color:rgba(255,255,255,0.2); }
        .field-textarea { width:100%; padding:11px 14px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08); border-radius:10px; color:#fff; font-size:14px; font-family:'Inter',sans-serif; outline:none; transition:all 0.3s; resize:vertical; min-height:90px; }
        .field-textarea:focus { border-color:rgba(124,58,237,0.6); background:rgba(124,58,237,0.06); }
        .field-textarea::placeholder { color:rgba(255,255,255,0.2); }

        /* Saved Addresses */
        .address-option { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:10px; padding:12px 14px; margin-bottom:8px; cursor:pointer; transition:all 0.2s; display:flex; align-items:flex-start; gap:10px; }
        .address-option:hover { border-color:rgba(124,58,237,0.3); }
        .address-option.selected { border-color:rgba(124,58,237,0.5); background:rgba(124,58,237,0.08); }
        .address-option input[type="radio"] { accent-color:#7c3aed; margin-top:3px; flex-shrink:0; }
        .address-option-body { flex:1; }
        .address-option-name { font-size:13px; font-weight:700; margin-bottom:2px; }
        .address-option-text { font-size:12px; color:rgba(255,255,255,0.45); line-height:1.5; }
        .address-label-badge { display:inline-flex; align-items:center; gap:4px; padding:2px 8px; border-radius:20px; font-size:10px; font-weight:700; margin-bottom:4px; }
        .label-home { background:rgba(96,165,250,0.15); color:#93c5fd; }
        .label-office { background:rgba(251,191,36,0.15); color:#fcd34d; }
        .label-other { background:rgba(167,139,250,0.15); color:#c4b5fd; }

        /* Errors */
        .alert-error { background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#fca5a5; padding:12px 18px; border-radius:12px; margin-bottom:20px; font-size:14px; }

        /* Summary */
        .summary-card { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:16px; padding:24px; position:sticky; top:80px; }
        .summary-title { font-size:15px; font-weight:700; margin-bottom:16px; padding-bottom:14px; border-bottom:1px solid rgba(255,255,255,0.06); }
        .summary-item { display:flex; gap:12px; margin-bottom:12px; }
        .summary-item-img { width:48px; height:60px; object-fit:cover; border-radius:6px; flex-shrink:0; }
        .summary-item-placeholder { width:48px; height:60px; border-radius:6px; background:linear-gradient(135deg,rgba(124,58,237,0.2),rgba(168,85,247,0.1)); display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
        .summary-item-title { font-size:13px; font-weight:700; margin-bottom:2px; }
        .summary-item-author { font-size:11px; color:rgba(255,255,255,0.4); }
        .summary-item-price { font-size:13px; font-weight:700; color:#a78bfa; margin-top:4px; }

        .divider { border-top:1px solid rgba(255,255,255,0.06); margin:14px 0; }
        .price-row { display:flex; justify-content:space-between; margin-bottom:8px; }
        .price-label { font-size:13px; color:rgba(255,255,255,0.5); }
        .price-value { font-size:13px; font-weight:600; }
        .price-discount { color:#6ee7b7; }
        .total-row { display:flex; justify-content:space-between; align-items:center; margin-top:14px; padding-top:14px; border-top:2px solid rgba(255,255,255,0.08); }
        .total-label { font-size:16px; font-weight:700; }
        .total-value { font-size:26px; font-weight:900; background:linear-gradient(135deg,#a78bfa,#f472b6); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }

        /* Place Order Btn */
        .btn-place-order { display:block; width:100%; padding:16px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; border:none; border-radius:12px; font-size:16px; font-weight:800; cursor:pointer; font-family:'Inter',sans-serif; text-align:center; margin-top:20px; transition:all 0.3s; box-shadow:0 6px 25px rgba(124,58,237,0.35); }
        .btn-place-order:hover { transform:translateY(-2px); box-shadow:0 10px 35px rgba(124,58,237,0.55); }
        .security-note { text-align:center; font-size:11px; color:rgba(255,255,255,0.25); margin-top:10px; }

        /* Coupon in summary */
        .coupon-applied { background:rgba(52,211,153,0.08); border:1px solid rgba(52,211,153,0.2); border-radius:8px; padding:8px 12px; margin-bottom:10px; display:flex; justify-content:space-between; align-items:center; }
        .coupon-applied-text { font-size:12px; color:#6ee7b7; font-weight:600; }
        .coupon-remove { background:none; border:none; color:#f87171; font-size:12px; cursor:pointer; font-family:'Inter',sans-serif; }
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
        <a href="{{ route('cart.index') }}" class="nav-link">🛒 Back to Cart</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
</nav>

{{-- Steps --}}
<div class="checkout-steps">
    <div class="step">
        <div class="step-dot done">✓</div>
        <div class="step-label">Cart</div>
    </div>
    <div class="step">
        <div class="step-dot active">2</div>
        <div class="step-label active">Checkout</div>
    </div>
    <div class="step">
        <div class="step-dot pending">3</div>
        <div class="step-label">Payment</div>
    </div>
    <div class="step">
        <div class="step-dot pending">4</div>
        <div class="step-label">Done</div>
    </div>
</div>

<div class="page">

    @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
                <div>❌ {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="checkout-layout">

        {{-- Left: Shipping Form --}}
        <div>
            <form method="POST" action="{{ route('orders.store') }}" id="checkout-form">
                @csrf

                {{-- Personal Info --}}
                <div class="card">
                    <div class="card-title">👤 Personal Information</div>
                    <div class="field">
                        <label class="field-label">Full Name</label>
                        <input type="text" class="field-input" value="{{ auth()->user()->name }}" disabled>
                    </div>
                    <div class="field">
                        <label class="field-label">Email</label>
                        <input type="text" class="field-input" value="{{ auth()->user()->email }}" disabled>
                    </div>
                    @if(auth()->user()->phone)
                        <div class="field">
                            <label class="field-label">Phone</label>
                            <input type="text" class="field-input" value="{{ auth()->user()->phone }}" disabled>
                        </div>
                    @endif
                </div>

                {{-- Shipping Address --}}
                <div class="card">
                    <div class="card-title">📍 Shipping Address</div>

                    {{-- Saved Addresses --}}
                    @php $addresses = auth()->user()->addresses()->get(); @endphp
                    @if($addresses->count() > 0)
                        <div style="margin-bottom:14px;">
                            <div style="font-size:12px; color:rgba(255,255,255,0.4); margin-bottom:10px; font-weight:600;">SAVED ADDRESSES</div>
                            @foreach($addresses as $addr)
                                <label class="address-option {{ $addr->is_default ? 'selected' : '' }}" onclick="selectAddress(this, '{{ $addr->address_line }}, {{ $addr->city }}, {{ $addr->district }}{{ $addr->postal_code ? " - ".$addr->postal_code : "" }}')">
                                    <input type="radio" name="_address_select" {{ $addr->is_default ? 'checked' : '' }}>
                                    <div class="address-option-body">
                                        <span class="address-label-badge {{ $addr->label === 'Home' ? 'label-home' : ($addr->label === 'Office' ? 'label-office' : 'label-other') }}">
                                            {{ $addr->label === 'Home' ? '🏠' : ($addr->label === 'Office' ? '🏢' : '📌') }} {{ $addr->label }}
                                        </span>
                                        <div class="address-option-name">{{ $addr->recipient_name }} · {{ $addr->phone }}</div>
                                        <div class="address-option-text">{{ $addr->address_line }}, {{ $addr->city }}, {{ $addr->district }}{{ $addr->postal_code ? ' - '.$addr->postal_code : '' }}</div>
                                    </div>
                                </label>
                            @endforeach
                            <div style="font-size:12px; color:rgba(255,255,255,0.3); margin:10px 0; text-align:center;">— or enter manually —</div>
                        </div>
                    @endif

                    <div class="field">
                        <label class="field-label">Full Shipping Address *</label>
                        <textarea name="shipping_address" class="field-textarea" id="shipping_address"
                                  placeholder="House no., street, area, city, district..." required>{{ old('shipping_address', $addresses->where('is_default', true)->first()?->address_line . ', ' . $addresses->where('is_default', true)->first()?->city . ', ' . $addresses->where('is_default', true)->first()?->district) }}</textarea>
                    </div>
                </div>

                {{-- Order Note --}}
                <div class="card">
                    <div class="card-title">📝 Order Note (Optional)</div>
                    <textarea name="order_note" class="field-textarea" placeholder="Write any special note for the seller here...."></textarea>
                </div>

            </form>
        </div>

        {{-- Right: Summary --}}
        <div>
            <div class="summary-card">
                <div class="summary-title">📋 Order Summary</div>

                {{-- Items --}}
                @foreach($cart as $item)
                    <div class="summary-item">
                        @if($item['image'])
                            <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['title'] }}" class="summary-item-img">
                        @else
                            <div class="summary-item-placeholder">📚</div>
                        @endif
                        <div>
                            <div class="summary-item-title">{{ $item['title'] }}</div>
                            <div class="summary-item-author">by {{ $item['author'] }}</div>
                            <div class="summary-item-price">৳{{ number_format($item['price'], 0) }}</div>
                        </div>
                    </div>
                @endforeach

                <div class="divider"></div>

                {{-- Coupon Applied --}}
                @if(session('coupon'))
                    <div class="coupon-applied">
                        <span class="coupon-applied-text">🎟️ {{ session('coupon.code') }} — ৳{{ session('coupon.discount') }} off</span>
                        <form method="POST" action="{{ route('coupon.remove') }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="coupon-remove">✕</button>
                        </form>
                    </div>
                @endif

                {{-- Price Breakdown --}}
                @php $discount = session('coupon.discount') ?? 0; $finalTotal = $total - $discount; @endphp

                <div class="price-row">
                    <span class="price-label">Subtotal ({{ count($cart) }} items)</span>
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
                    <span class="price-value" style="color:#6ee7b7;">Free 🎁</span>
                </div>

                <div class="total-row">
                    <span class="total-label">Total</span>
                    <span class="total-value">৳{{ number_format($finalTotal, 0) }}</span>
                </div>

                <button type="submit" form="checkout-form" class="btn-place-order">
                    🚀 Place Order
                </button>

                <div class="security-note">🔒 256-bit SSL Encrypted · Secure Checkout</div>
            </div>
        </div>
    </div>
</div>

<script>
function selectAddress(el, address) {
    document.querySelectorAll('.address-option').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('shipping_address').value = address;
}
</script>

</body>
</html>