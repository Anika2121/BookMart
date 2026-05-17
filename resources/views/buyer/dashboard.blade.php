<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
    <title>Buyer Dashboard - BookMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#09090f; color:#fff; min-height:100vh; }
        ::-webkit-scrollbar { width:5px; }
        ::-webkit-scrollbar-thumb { background:rgba(124,58,237,0.4); border-radius:4px; }

        .layout { display:flex; min-height:100vh; }

        /* SIDEBAR */
        .sidebar { width:240px; flex-shrink:0; background:#0c0c18; border-right:0.5px solid rgba(255,255,255,0.06); display:flex; flex-direction:column; position:fixed; top:0; left:0; height:100vh; z-index:50; }
        .sb-brand { padding:24px 20px; border-bottom:0.5px solid rgba(255,255,255,0.06); display:flex; align-items:center; gap:10px; }
        .sb-brand-icon { width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,#7c3aed,#4f46e5); display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0; }
        .sb-brand-name { font-size:16px; font-weight:800; color:#fff; }
        .sb-brand-name span { background:linear-gradient(135deg,#a78bfa,#60a5fa); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .sb-user-info { padding:16px 20px; border-bottom:0.5px solid rgba(255,255,255,0.06); }
        .sb-avatar { width:40px; height:40px; border-radius:50%; background:linear-gradient(135deg,#7c3aed,#a855f7); display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:800; margin-bottom:8px; overflow:hidden; }
        .sb-avatar img { width:100%; height:100%; object-fit:cover; }
        .sb-name { font-size:13px; font-weight:600; color:#fff; }
        .sb-role { font-size:11px; color:rgba(255,255,255,0.35); margin-top:2px; display:flex; align-items:center; gap:4px; }
        .sb-role-dot { width:6px; height:6px; border-radius:50%; background:#34d399; animation:blink 2s infinite; }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }
        .sb-nav { flex:1; padding:12px 10px; overflow-y:auto; }
        .sb-section-label { font-size:10px; font-weight:700; color:rgba(255,255,255,0.25); text-transform:uppercase; letter-spacing:1px; padding:8px 10px 4px; }
        .sb-link { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; text-decoration:none; color:rgba(255,255,255,0.5); font-size:13px; font-weight:500; transition:all 0.2s; margin-bottom:2px; border:1px solid transparent; }
        .sb-link:hover { background:rgba(255,255,255,0.05); color:#fff; }
        .sb-link.active { background:rgba(124,58,237,0.15); color:#a78bfa; border-color:rgba(124,58,237,0.2); }
        .sb-link-icon { font-size:15px; width:20px; text-align:center; }
        .sb-link-badge { margin-left:auto; font-size:10px; padding:2px 7px; border-radius:10px; background:rgba(239,68,68,0.2); color:#f87171; font-weight:700; }
        .sb-bottom { padding:16px; border-top:0.5px solid rgba(255,255,255,0.06); }
        .sb-logout { width:100%; padding:10px; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); border-radius:10px; color:#f87171; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .sb-logout:hover { background:rgba(239,68,68,0.2); }

        /* MAIN */
        .main { margin-left:240px; flex:1; padding:28px 32px; }

        /* TOPBAR */
        .topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; }
        .topbar-left h1 { font-size:22px; font-weight:700; color:#fff; letter-spacing:-0.4px; }
        .topbar-left p { font-size:13px; color:rgba(255,255,255,0.35); margin-top:3px; }
        .topbar-right { display:flex; gap:10px; }
        .btn-browse { display:flex; align-items:center; gap:7px; padding:10px 20px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; border-radius:10px; font-size:13px; font-weight:700; text-decoration:none; transition:all 0.2s; }
        .btn-browse:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(124,58,237,0.4); }

        /* ALERT */
        .alert { padding:12px 18px; border-radius:12px; margin-bottom:24px; font-size:13px; display:flex; align-items:center; gap:8px; }
        .alert-success { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#6ee7b7; }

        /* PROFILE HERO */
        .profile-hero { background:linear-gradient(135deg,rgba(124,58,237,0.12),rgba(79,70,229,0.08)); border:0.5px solid rgba(124,58,237,0.2); border-radius:18px; padding:24px 28px; margin-bottom:24px; display:flex; align-items:center; gap:20px; flex-wrap:wrap; position:relative; overflow:hidden; }
        .profile-hero::before { content:''; position:absolute; top:-30px; right:-30px; width:150px; height:150px; background:radial-gradient(circle,rgba(124,58,237,0.15),transparent 70%); border-radius:50%; }
        .profile-avatar-wrap { position:relative; flex-shrink:0; }
        .profile-avatar { width:72px; height:72px; border-radius:50%; background:linear-gradient(135deg,#7c3aed,#4f46e5); display:flex; align-items:center; justify-content:center; font-size:26px; font-weight:800; border:3px solid rgba(124,58,237,0.3); overflow:hidden; }
        .profile-avatar img { width:100%; height:100%; object-fit:cover; }
        .online-dot { position:absolute; bottom:3px; right:3px; width:13px; height:13px; border-radius:50%; background:#34d399; border:2px solid #09090f; }
        .profile-info { flex:1; }
        .profile-name { font-size:20px; font-weight:700; color:#fff; margin-bottom:4px; letter-spacing:-0.3px; }
        .profile-email { font-size:13px; color:rgba(255,255,255,0.4); margin-bottom:10px; }
        .profile-badges { display:flex; gap:7px; flex-wrap:wrap; }
        .pbadge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
        .pbadge-buyer { background:rgba(52,211,153,0.1); color:#6ee7b7; border:0.5px solid rgba(52,211,153,0.2); }
        .pbadge-phone { background:rgba(96,165,250,0.1); color:#93c5fd; border:0.5px solid rgba(96,165,250,0.2); }
        .pbadge-del { background:rgba(239,68,68,0.1); color:#f87171; border:0.5px solid rgba(239,68,68,0.2); }
        .btn-edit-profile { padding:9px 18px; background:rgba(124,58,237,0.15); border:0.5px solid rgba(124,58,237,0.3); color:#a78bfa; border-radius:10px; text-decoration:none; font-size:13px; font-weight:600; transition:all 0.2s; white-space:nowrap; }
        .btn-edit-profile:hover { background:rgba(124,58,237,0.25); }

        /* STATS */
        .stats-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:14px; margin-bottom:24px; }
        @media(max-width:1200px) { .stats-grid { grid-template-columns:repeat(3,1fr); } }
        .stat-card { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:14px; padding:18px; text-align:center; text-decoration:none; display:block; transition:all 0.2s; position:relative; overflow:hidden; }
        .stat-card::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; border-radius:14px 14px 0 0; }
        .stat-card.purple::before { background:linear-gradient(90deg,#7c3aed,#a855f7); }
        .stat-card.yellow::before { background:linear-gradient(90deg,#d97706,#fbbf24); }
        .stat-card.green::before { background:linear-gradient(90deg,#059669,#34d399); }
        .stat-card.pink::before { background:linear-gradient(90deg,#db2777,#f472b6); }
        .stat-card.blue::before { background:linear-gradient(90deg,#2563eb,#60a5fa); }
        .stat-card:hover { border-color:rgba(255,255,255,0.15); transform:translateY(-2px); }
        .stat-icon { font-size:24px; margin-bottom:8px; }
        .stat-num { font-size:26px; font-weight:800; color:#fff; margin-bottom:4px; }
        .stat-label { font-size:11px; color:rgba(255,255,255,0.35); font-weight:500; }

        /* QUICK ACTIONS */
        .quick-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:24px; }
        .qa { display:flex; align-items:center; gap:12px; padding:14px 16px; background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:13px; text-decoration:none; transition:all 0.2s; }
        .qa:hover { border-color:rgba(124,58,237,0.35); background:rgba(124,58,237,0.07); transform:translateX(3px); }
        .qa-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0; }
        .qa-text h4 { font-size:13px; font-weight:600; color:#fff; }
        .qa-text p { font-size:11px; color:rgba(255,255,255,0.35); margin-top:1px; }
        .qa-arrow { margin-left:auto; color:rgba(255,255,255,0.2); font-size:14px; }

        /* TWO COL */
        .two-col { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px; }
        @media(max-width:1000px) { .two-col { grid-template-columns:1fr; } }

        /* CARD */
        .card { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:16px; overflow:hidden; }
        .card-header { padding:16px 20px; border-bottom:0.5px solid rgba(255,255,255,0.06); display:flex; justify-content:space-between; align-items:center; }
        .card-title { font-size:14px; font-weight:700; color:#fff; }
        .card-link { font-size:12px; color:#a78bfa; text-decoration:none; font-weight:600; }
        .card-link:hover { color:#c4b5fd; }

        /* ORDER ROWS */
        .order-item { display:flex; align-items:center; gap:12px; padding:14px 20px; border-bottom:0.5px solid rgba(255,255,255,0.04); transition:background 0.15s; }
        .order-item:last-child { border-bottom:none; }
        .order-item:hover { background:rgba(255,255,255,0.02); }
        .order-img { width:44px; height:54px; object-fit:cover; border-radius:6px; flex-shrink:0; }
        .order-placeholder { width:44px; height:54px; border-radius:6px; background:rgba(124,58,237,0.15); display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
        .order-info { flex:1; min-width:0; }
        .order-title { font-size:13px; font-weight:600; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .order-seller { font-size:11px; color:rgba(255,255,255,0.35); margin-top:2px; }
        .order-price { font-size:13px; font-weight:700; color:#a78bfa; flex-shrink:0; }
        .order-date { font-size:11px; color:rgba(255,255,255,0.25); flex-shrink:0; }

        /* BADGES */
        .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600; flex-shrink:0; }
        .badge-pending { background:rgba(251,191,36,0.12); color:#fbbf24; border:0.5px solid rgba(251,191,36,0.25); }
        .badge-confirmed { background:rgba(96,165,250,0.12); color:#60a5fa; border:0.5px solid rgba(96,165,250,0.25); }
        .badge-shipped { background:rgba(167,139,250,0.12); color:#a78bfa; border:0.5px solid rgba(167,139,250,0.25); }
        .badge-delivered { background:rgba(52,211,153,0.12); color:#34d399; border:0.5px solid rgba(52,211,153,0.25); }
        .badge-cancelled { background:rgba(239,68,68,0.12); color:#f87171; border:0.5px solid rgba(239,68,68,0.25); }

        /* WISHLIST */
        .wish-item { display:flex; align-items:center; gap:12px; padding:14px 20px; border-bottom:0.5px solid rgba(255,255,255,0.04); transition:background 0.15s; text-decoration:none; }
        .wish-item:last-child { border-bottom:none; }
        .wish-item:hover { background:rgba(255,255,255,0.02); }
        .wish-img { width:44px; height:54px; object-fit:cover; border-radius:6px; flex-shrink:0; }
        .wish-placeholder { width:44px; height:54px; border-radius:6px; background:rgba(239,68,68,0.1); display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
        .wish-info { flex:1; min-width:0; }
        .wish-title { font-size:13px; font-weight:600; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .wish-author { font-size:11px; color:rgba(255,255,255,0.35); margin-top:2px; }
        .wish-price { font-size:13px; font-weight:700; color:#f472b6; flex-shrink:0; }

        /* SPENDING CHART */
        .chart-wrap { padding:20px; }

        /* ADDRESS */
        .addr-item { display:flex; align-items:flex-start; gap:12px; padding:14px 20px; border-bottom:0.5px solid rgba(255,255,255,0.04); }
        .addr-item:last-child { border-bottom:none; }
        .addr-icon { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:14px; flex-shrink:0; background:rgba(124,58,237,0.1); }
        .addr-info { flex:1; }
        .addr-name { font-size:13px; font-weight:600; color:#fff; }
        .addr-text { font-size:11px; color:rgba(255,255,255,0.35); margin-top:3px; line-height:1.5; }
        .addr-default { font-size:10px; color:#a78bfa; font-weight:700; margin-top:4px; }

        /* EMPTY */
        .empty { padding:32px; text-align:center; color:rgba(255,255,255,0.25); }
        .empty-icon { font-size:32px; margin-bottom:8px; }
        .empty p { font-size:13px; }

        @media(max-width:768px) { .sidebar { display:none; } .main { margin-left:0; padding:20px 16px; } .stats-grid { grid-template-columns:repeat(2,1fr); } .quick-grid { grid-template-columns:repeat(2,1fr); } }
    </style>
</head>
<body>
<div class="layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sb-brand">
      <div class="sb-brand-icon">📚</div>
      <div class="sb-brand-name">Book<span>Mart</span></div>
    </div>
    <div class="sb-user-info">
      <div class="sb-avatar">
        @if($user->avatar)
          <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}">
        @else
          {{ strtoupper(substr($user->name,0,1)) }}
        @endif
      </div>
      <div class="sb-name">{{ $user->name }}</div>
      <div class="sb-role"><span class="sb-role-dot"></span> Verified Buyer</div>
    </div>
    <nav class="sb-nav">
      <div class="sb-section-label">Main</div>
      <a href="{{ route('buyer.dashboard') }}" class="sb-link active">
        <span class="sb-link-icon">📊</span> Dashboard
      </a>
      <a href="{{ route('books.index') }}" class="sb-link">
        <span class="sb-link-icon">📚</span> Browse Books
      </a>

      <div class="sb-section-label" style="margin-top:8px;">Shopping</div>
      <a href="{{ route('orders.my') }}" class="sb-link">
        <span class="sb-link-icon">📦</span> My Orders
        @php $pendingCount = $user->buyerOrders()->where('status','pending')->count(); @endphp
        @if($pendingCount > 0)
          <span class="sb-link-badge">{{ $pendingCount }}</span>
        @endif
      </a>
      <a href="{{ route('wishlist.index') }}" class="sb-link">
        <span class="sb-link-icon">❤️</span> Wishlist
      </a>
      <a href="{{ route('cart.index') }}" class="sb-link">
        <span class="sb-link-icon">🛒</span> Cart
      </a>

      <div class="sb-section-label" style="margin-top:8px;">Account</div>
      <a href="{{ route('buyer.profile') }}" class="sb-link">
        <span class="sb-link-icon">👤</span> Profile
      </a>
      <a href="{{ route('addresses.index') }}" class="sb-link">
        <span class="sb-link-icon">📍</span> Addresses
      </a>
    </nav>
    <div class="sb-bottom">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sb-logout">🚪 Logout</button>
      </form>
    </div>
  </aside>

  <!-- MAIN -->
  <main class="main">

    <!-- TOPBAR -->
    <div class="topbar">
      <div class="topbar-left">
        <h1>My Dashboard 📊</h1>
        <p>{{ now()->format('l, d F Y') }} · Welcome back, {{ $user->name }}!</p>
      </div>
      <div class="topbar-right">
        <a href="{{ route('books.index') }}" class="btn-browse">📚 Browse Books</a>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <!-- PROFILE HERO -->
    <div class="profile-hero">
      <div class="profile-avatar-wrap">
        <div class="profile-avatar">
          @if($user->avatar)
            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}">
          @else
            {{ strtoupper(substr($user->name,0,1)) }}
          @endif
        </div>
        <div class="online-dot"></div>
      </div>
      <div class="profile-info">
        <div class="profile-name">{{ $user->name }}</div>
        <div class="profile-email">{{ $user->email }}</div>
        <div class="profile-badges">
          <span class="pbadge pbadge-buyer">✅ Verified Buyer</span>
          @if($user->phone)
            <span class="pbadge pbadge-phone">📞 {{ $user->phone }}</span>
          @endif
          @if($user->hasRequestedDeletion())
            <span class="pbadge pbadge-del">⚠️ Deletion Pending</span>
          @endif
        </div>
      </div>
      <a href="{{ route('buyer.profile') }}" class="btn-edit-profile">✏️ Edit Profile</a>
    </div>

    <!-- STATS -->
    @php
        $totalOrders     = $user->buyerOrders()->count();
        $pendingOrders   = $user->buyerOrders()->where('status','pending')->count();
        $deliveredOrders = $user->buyerOrders()->where('status','delivered')->count();
        $totalSpent      = $user->buyerOrders()->whereIn('status',['confirmed','shipped','delivered'])->sum('price');
        $wishlistCount   = \App\Models\Wishlist::where('user_id',$user->id)->count();
    @endphp
    <div class="stats-grid">
      <a href="{{ route('orders.my') }}" class="stat-card purple">
        <div class="stat-icon">📦</div>
        <div class="stat-num">{{ $totalOrders }}</div>
        <div class="stat-label">Total Orders</div>
      </a>
      <a href="{{ route('orders.my') }}" class="stat-card yellow">
        <div class="stat-icon">⏳</div>
        <div class="stat-num">{{ $pendingOrders }}</div>
        <div class="stat-label">Pending</div>
      </a>
      <a href="{{ route('orders.my') }}" class="stat-card green">
        <div class="stat-icon">✅</div>
        <div class="stat-num">{{ $deliveredOrders }}</div>
        <div class="stat-label">Delivered</div>
      </a>
      <div class="stat-card pink">
        <div class="stat-icon">💰</div>
        <div class="stat-num">৳{{ number_format($totalSpent,0) }}</div>
        <div class="stat-label">Total Spent</div>
      </div>
      <a href="{{ route('wishlist.index') }}" class="stat-card blue">
        <div class="stat-icon">❤️</div>
        <div class="stat-num">{{ $wishlistCount }}</div>
        <div class="stat-label">Wishlist</div>
      </a>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="quick-grid">
      <a href="{{ route('books.index') }}" class="qa">
        <div class="qa-icon" style="background:rgba(124,58,237,0.15);">📚</div>
        <div class="qa-text"><h4>Browse Books</h4><p>Find your next read</p></div>
        <span class="qa-arrow">→</span>
      </a>
      <a href="{{ route('orders.my') }}" class="qa">
        <div class="qa-icon" style="background:rgba(251,191,36,0.15);">📦</div>
        <div class="qa-text"><h4>My Orders</h4><p>Track & manage</p></div>
        <span class="qa-arrow">→</span>
      </a>
      <a href="{{ route('wishlist.index') }}" class="qa">
        <div class="qa-icon" style="background:rgba(239,68,68,0.15);">❤️</div>
        <div class="qa-text"><h4>Wishlist</h4><p>Saved for later</p></div>
        <span class="qa-arrow">→</span>
      </a>
      <a href="{{ route('cart.index') }}" class="qa">
        <div class="qa-icon" style="background:rgba(52,211,153,0.15);">🛒</div>
        <div class="qa-text"><h4>My Cart</h4><p>Ready to checkout</p></div>
        <span class="qa-arrow">→</span>
      </a>
    </div>

    <!-- TWO COL -->
    <div class="two-col">

      <!-- RECENT ORDERS -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">📦 Recent Orders</span>
          <a href="{{ route('orders.my') }}" class="card-link">View all →</a>
        </div>
        @if($orders->isEmpty())
          <div class="empty">
            <div class="empty-icon">📭</div>
            <p>No orders yet. <a href="{{ route('books.index') }}" style="color:#a78bfa;">Browse books →</a></p>
          </div>
        @else
          @foreach($orders->take(5) as $order)
            <div class="order-item">
              @if($order->book->image)
                <img src="{{ Storage::url($order->book->image) }}" alt="{{ $order->book->title }}" class="order-img">
              @else
                <div class="order-placeholder">📚</div>
              @endif
              <div class="order-info">
                <div class="order-title">{{ Str::limit($order->book->title,28) }}</div>
                <div class="order-seller">{{ $order->book->user->name ?? '' }}</div>
              </div>
              <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
              <div class="order-price">৳{{ number_format($order->price,0) }}</div>
            </div>
          @endforeach
        @endif
      </div>

      <!-- WISHLIST -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">❤️ Wishlist</span>
          <a href="{{ route('wishlist.index') }}" class="card-link">View all →</a>
        </div>
        @php $wishlists = \App\Models\Wishlist::with('book')->where('user_id',$user->id)->latest()->take(5)->get(); @endphp
        @if($wishlists->isEmpty())
          <div class="empty">
            <div class="empty-icon">💔</div>
            <p>No books saved yet.</p>
          </div>
        @else
          @foreach($wishlists as $wish)
            <a href="{{ route('books.show',$wish->book) }}" class="wish-item">
              @if($wish->book->image)
                <img src="{{ Storage::url($wish->book->image) }}" alt="{{ $wish->book->title }}" class="wish-img">
              @else
                <div class="wish-placeholder">📚</div>
              @endif
              <div class="wish-info">
                <div class="wish-title">{{ Str::limit($wish->book->title,28) }}</div>
                <div class="wish-author">{{ $wish->book->author }}</div>
              </div>
              <div class="wish-price">৳{{ number_format($wish->book->price,0) }}</div>
            </a>
          @endforeach
        @endif
      </div>
    </div>

    <!-- SAVED ADDRESSES -->
    <div class="card">
      <div class="card-header">
        <span class="card-title">📍 Saved Addresses</span>
        <a href="{{ route('addresses.index') }}" class="card-link">Manage →</a>
      </div>
      @if($addresses->isEmpty())
        <div class="empty">
          <div class="empty-icon">📍</div>
          <p>No addresses saved. <a href="{{ route('buyer.profile') }}" style="color:#a78bfa;">Add one →</a></p>
        </div>
      @else
        @foreach($addresses as $addr)
          <div class="addr-item">
            <div class="addr-icon">
              {{ $addr->label === 'Home' ? '🏠' : ($addr->label === 'Office' ? '🏢' : '📌') }}
            </div>
            <div class="addr-info">
              <div class="addr-name">{{ $addr->recipient_name }} · {{ $addr->label }}</div>
              <div class="addr-text">{{ $addr->address_line }}, {{ $addr->city }}, {{ $addr->district }}</div>
              @if($addr->is_default)
                <div class="addr-default">⭐ Default Address</div>
              @endif
            </div>
          </div>
        @endforeach
      @endif
    </div>

  </main>
</div>
</body>
</html>