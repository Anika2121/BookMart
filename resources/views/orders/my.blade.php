<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>??</text></svg>">
    <title>My Orders - BookMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#0a0a0f; color:#fff; min-height:100vh; }

        /* Navbar */
        .navbar {
            position:sticky; top:0; z-index:100;
            background:rgba(10,10,15,0.95); backdrop-filter:blur(20px);
            border-bottom:1px solid rgba(255,255,255,0.06);
            padding:14px 32px; display:flex; justify-content:space-between; align-items:center;
        }
        .nav-brand { display:flex; align-items:center; gap:10px; text-decoration:none; }
        .nav-brand-icon {
            width:36px; height:36px; border-radius:10px;
            background:linear-gradient(135deg,#7c3aed,#4f46e5);
            display:flex; align-items:center; justify-content:center; font-size:16px;
        }
        .nav-brand-name { font-size:18px; font-weight:900; color:#fff; }
        .nav-brand-name span { background:linear-gradient(135deg,#a78bfa,#60a5fa); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .nav-links { display:flex; align-items:center; gap:8px; }
        .nav-link { padding:8px 16px; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600; color:rgba(255,255,255,0.6); transition:all 0.2s; }
        .nav-link:hover { background:rgba(255,255,255,0.06); color:#fff; }
        .nav-link.active { background:rgba(124,58,237,0.2); color:#a78bfa; }
        .btn-logout { padding:8px 16px; border-radius:8px; border:none; background:rgba(239,68,68,0.1); color:#f87171; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .btn-logout:hover { background:rgba(239,68,68,0.2); }

        /* Page */
        .page { max-width:1000px; margin:0 auto; padding:40px 24px; }
        .page-header { margin-bottom:28px; }
        .page-header h1 { font-size:28px; font-weight:800; }
        .page-header p { color:rgba(255,255,255,0.4); font-size:14px; margin-top:4px; }

        /* Alerts */
        .alert { padding:12px 18px; border-radius:12px; margin-bottom:20px; font-size:14px; display:flex; align-items:center; gap:8px; }
        .alert-success { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#6ee7b7; }
        .alert-error { background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#fca5a5; }

        /* Stats */
        .stats-row { display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:12px; margin-bottom:28px; }
        .stat-card { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:14px; padding:16px; text-align:center; }
        .stat-num { font-size:24px; font-weight:800; margin-bottom:4px; }
        .stat-label { font-size:12px; color:rgba(255,255,255,0.4); }

        /* Order Cards */
        .order-card { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:16px; margin-bottom:16px; overflow:hidden; transition:all 0.2s; }
        .order-card:hover { border-color:rgba(255,255,255,0.12); }
        .order-header { display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-bottom:1px solid rgba(255,255,255,0.05); flex-wrap:wrap; gap:10px; }
        .order-id { font-size:13px; color:rgba(255,255,255,0.4); font-weight:500; }
        .order-date { font-size:12px; color:rgba(255,255,255,0.35); }
        .order-body { display:flex; gap:16px; padding:16px 20px; align-items:flex-start; flex-wrap:wrap; }
        .order-book-img { width:70px; height:90px; object-fit:cover; border-radius:8px; flex-shrink:0; }
        .order-book-placeholder { width:70px; height:90px; border-radius:8px; background:linear-gradient(135deg,rgba(124,58,237,0.2),rgba(168,85,247,0.1)); display:flex; align-items:center; justify-content:center; font-size:28px; flex-shrink:0; }
        .order-info { flex:1; min-width:200px; }
        .order-title { font-size:16px; font-weight:700; margin-bottom:4px; }
        .order-seller { font-size:13px; color:rgba(255,255,255,0.4); margin-bottom:8px; }
        .order-address { font-size:12px; color:rgba(255,255,255,0.35); line-height:1.5; }
        .order-footer { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-top:1px solid rgba(255,255,255,0.05); flex-wrap:wrap; gap:10px; }
        .order-price { font-size:20px; font-weight:800; background:linear-gradient(135deg,#a78bfa,#f472b6); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .order-actions { display:flex; gap:8px; flex-wrap:wrap; align-items:center; }

        /* Status Badge */
        .status-badge { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; border-radius:20px; font-size:12px; font-weight:700; }
        .status-pending   { background:rgba(251,191,36,0.15); color:#fcd34d; border:1px solid rgba(251,191,36,0.25); }
        .status-confirmed { background:rgba(96,165,250,0.15); color:#93c5fd; border:1px solid rgba(96,165,250,0.25); }
        .status-shipped   { background:rgba(167,139,250,0.15); color:#c4b5fd; border:1px solid rgba(167,139,250,0.25); }
        .status-delivered { background:rgba(52,211,153,0.15); color:#6ee7b7; border:1px solid rgba(52,211,153,0.25); }
        .status-cancelled { background:rgba(239,68,68,0.15); color:#fca5a5; border:1px solid rgba(239,68,68,0.25); }

        /* Buttons */
        .btn { padding:8px 18px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; text-decoration:none; border:none; transition:all 0.2s; display:inline-flex; align-items:center; gap:6px; }
        .btn-pay { background:linear-gradient(135deg,#059669,#10b981); color:#fff; box-shadow:0 4px 12px rgba(16,185,129,0.3); }
        .btn-pay:hover { transform:translateY(-1px); box-shadow:0 6px 16px rgba(16,185,129,0.4); }
        .btn-invoice { background:rgba(96,165,250,0.1); color:#93c5fd; border:1px solid rgba(96,165,250,0.2); }
        .btn-invoice:hover { background:rgba(96,165,250,0.2); }
        .btn-cancel { background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2); }
        .btn-cancel:hover { background:rgba(239,68,68,0.2); }

        /* Progress bar */
        .order-progress { padding:12px 20px; background:rgba(255,255,255,0.02); }
        .progress-steps { display:flex; align-items:center; gap:0; }
        .progress-step { display:flex; flex-direction:column; align-items:center; flex:1; position:relative; }
        .progress-step::before { content:''; position:absolute; top:12px; left:-50%; width:100%; height:2px; background:rgba(255,255,255,0.08); z-index:0; }
        .progress-step:first-child::before { display:none; }
        .step-dot { width:24px; height:24px; border-radius:50%; border:2px solid rgba(255,255,255,0.15); background:#0a0a0f; display:flex; align-items:center; justify-content:center; font-size:10px; position:relative; z-index:1; transition:all 0.3s; }
        .step-dot.done { background:linear-gradient(135deg,#7c3aed,#a855f7); border-color:#7c3aed; }
        .step-dot.active { background:rgba(124,58,237,0.2); border-color:#a78bfa; box-shadow:0 0 10px rgba(124,58,237,0.4); }
        .step-label { font-size:10px; color:rgba(255,255,255,0.35); margin-top:5px; font-weight:500; }
        .step-label.done { color:#a78bfa; }
        .step-label.active { color:#fff; }

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
        <a href="{{ route('orders.my') }}" class="nav-link active">My Orders</a>
        <a href="{{ route('wishlist.index') }}" class="nav-link">❤️ Wishlist</a>
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
        <h1>📦 My Orders</h1>
        <p>You can see all your orders here</p>
    </div>

    @if($orders->isNotEmpty())
        {{-- Stats --}}
        @php
            $pending   = $orders->where('status','pending')->count();
            $confirmed = $orders->where('status','confirmed')->count();
            $shipped   = $orders->where('status','shipped')->count();
            $delivered = $orders->where('status','delivered')->count();
            $cancelled = $orders->where('status','cancelled')->count();
        @endphp
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-num" style="color:#fcd34d;">{{ $pending }}</div>
                <div class="stat-label">⏳ Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-num" style="color:#93c5fd;">{{ $confirmed }}</div>
                <div class="stat-label">✅ Confirmed</div>
            </div>
            <div class="stat-card">
                <div class="stat-num" style="color:#c4b5fd;">{{ $shipped }}</div>
                <div class="stat-label">🚚 Shipped</div>
            </div>
            <div class="stat-card">
                <div class="stat-num" style="color:#6ee7b7;">{{ $delivered }}</div>
                <div class="stat-label">📬 Delivered</div>
            </div>
            <div class="stat-card">
                <div class="stat-num" style="color:#fca5a5;">{{ $cancelled }}</div>
                <div class="stat-label">❌ Cancelled</div>
            </div>
        </div>

        {{-- Order Cards --}}
        @foreach($orders as $order)
            @php
                $stepMap = ['pending'=>0,'confirmed'=>1,'shipped'=>2,'delivered'=>3,'cancelled'=>-1];
                $currentStep = $stepMap[$order->status] ?? 0;
                $steps = [
                    ['label'=>'Pending',   'icon'=>'⏳'],
                    ['label'=>'Confirmed', 'icon'=>'✅'],
                    ['label'=>'Shipped',   'icon'=>'🚚'],
                    ['label'=>'Delivered', 'icon'=>'📬'],
                ];
            @endphp
            <div class="order-card">
                {{-- Header --}}
                <div class="order-header">
                    <div>
                        <div class="order-id">Order #{{ $order->id }}</div>
                        <div class="order-date">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                    @php
                        $statusClass = 'status-' . $order->status;
                        $statusIcon = match($order->status) {
                            'pending'   => '⏳',
                            'confirmed' => '✅',
                            'shipped'   => '🚚',
                            'delivered' => '📬',
                            'cancelled' => '❌',
                            default     => '📦',
                        };
                    @endphp
                    <span class="status-badge {{ $statusClass }}">
                        {{ $statusIcon }} {{ ucfirst($order->status) }}
                    </span>
                </div>

                {{-- Progress (hidden if cancelled) --}}
                @if($order->status !== 'cancelled')
                    <div class="order-progress">
                        <div class="progress-steps">
                            @foreach($steps as $i => $step)
                                <div class="progress-step">
                                    <div class="step-dot {{ $i < $currentStep ? 'done' : ($i === $currentStep ? 'active' : '') }}">
                                        {{ $i < $currentStep ? '✓' : $step['icon'] }}
                                    </div>
                                    <div class="step-label {{ $i < $currentStep ? 'done' : ($i === $currentStep ? 'active' : '') }}">
                                        {{ $step['label'] }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Body --}}
                <div class="order-body">
                    @if($order->book->image)
                        <img src="{{ Storage::url($order->book->image) }}" alt="{{ $order->book->title }}" class="order-book-img">
                    @else
                        <div class="order-book-placeholder">📚</div>
                    @endif
                    <div class="order-info">
                        <div class="order-title">{{ $order->book->title }}</div>
                        <div class="order-seller">by {{ $order->book->author }} • Seller: {{ $order->book->user->name }}</div>
                        <div class="order-address">
                            📍 {{ $order->shipping_address }}
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="order-footer">
                    <div class="order-price">৳{{ number_format($order->price, 0) }}</div>
                    <div class="order-actions">

                        {{-- Pay Now --}}
                        @if($order->status === 'pending' && (!isset($order->payment) || !$order->payment))
                            <a href="{{ route('payment.initiate', $order) }}" class="btn btn-pay">
                                💳 Pay Now
                            </a>
                        @endif

                        {{-- Invoice --}}
                        @if(isset($order->payment) && $order->payment && $order->payment->status === 'completed')
                            <a href="{{ route('payment.invoice', $order) }}" class="btn btn-invoice">
                                📄 Invoice
                            </a>
                        @endif

                        {{-- Cancel --}}
                        @if($order->status === 'pending')
                            <form method="POST"
                                  action="{{ route('orders.cancel', $order) }}"
                                  onsubmit="return confirm('Do you want to cancel this order?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-cancel">
                                    ✕ Cancel Order
                                </button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach

    @else
        <div class="empty-state">
            <div class="empty-icon">📦</div>
            <div class="empty-title">No orders found</div>
            <div class="empty-sub">You have not ordered any books yet</div>
            <a href="{{ route('books.index') }}" class="btn-browse">📚 Browse Books</a>
        </div>
    @endif

</div>
</body>
</html>