<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
    <title>Seller Dashboard - BookMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#09090f; color:#fff; min-height:100vh; }

        ::-webkit-scrollbar { width:5px; }
        ::-webkit-scrollbar-track { background:#09090f; }
        ::-webkit-scrollbar-thumb { background:rgba(124,58,237,0.4); border-radius:4px; }

        /* SIDEBAR */
        .layout { display:flex; min-height:100vh; }
        .sidebar { width:240px; flex-shrink:0; background:#0c0c18; border-right:0.5px solid rgba(255,255,255,0.06); display:flex; flex-direction:column; position:fixed; top:0; left:0; height:100vh; z-index:50; }
        .sb-brand { padding:24px 20px; border-bottom:0.5px solid rgba(255,255,255,0.06); display:flex; align-items:center; gap:10px; }
        .sb-brand-icon { width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,#7c3aed,#4f46e5); display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0; }
        .sb-brand-name { font-size:16px; font-weight:800; color:#fff; }
        .sb-brand-name span { background:linear-gradient(135deg,#a78bfa,#60a5fa); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .sb-seller-info { padding:16px 20px; border-bottom:0.5px solid rgba(255,255,255,0.06); }
        .sb-avatar { width:40px; height:40px; border-radius:50%; background:linear-gradient(135deg,#7c3aed,#a855f7); display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:800; margin-bottom:8px; }
        .sb-name { font-size:13px; font-weight:600; color:#fff; }
        .sb-role { font-size:11px; color:rgba(255,255,255,0.35); margin-top:2px; display:flex; align-items:center; gap:4px; }
        .sb-role-dot { width:6px; height:6px; border-radius:50%; background:#34d399; }
        .sb-nav { flex:1; padding:12px 10px; overflow-y:auto; }
        .sb-section-label { font-size:10px; font-weight:700; color:rgba(255,255,255,0.25); text-transform:uppercase; letter-spacing:1px; padding:8px 10px 4px; }
        .sb-link { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; text-decoration:none; color:rgba(255,255,255,0.5); font-size:13px; font-weight:500; transition:all 0.2s; margin-bottom:2px; border:1px solid transparent; }
        .sb-link:hover { background:rgba(255,255,255,0.05); color:#fff; }
        .sb-link.active { background:rgba(124,58,237,0.15); color:#a78bfa; border-color:rgba(124,58,237,0.2); }
        .sb-link-icon { font-size:15px; width:20px; text-align:center; }
        .sb-link-badge { margin-left:auto; font-size:10px; padding:2px 7px; border-radius:10px; background:rgba(124,58,237,0.2); color:#a78bfa; font-weight:700; }
        .sb-bottom { padding:16px; border-top:0.5px solid rgba(255,255,255,0.06); }
        .sb-logout { width:100%; padding:10px; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); border-radius:10px; color:#f87171; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .sb-logout:hover { background:rgba(239,68,68,0.2); }

        /* MAIN */
        .main { margin-left:240px; flex:1; padding:28px 32px; }

        /* TOPBAR */
        .topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; }
        .topbar-left h1 { font-size:22px; font-weight:700; color:#fff; letter-spacing:-0.4px; }
        .topbar-left p { font-size:13px; color:rgba(255,255,255,0.35); margin-top:3px; }
        .topbar-right { display:flex; align-items:center; gap:10px; }
        .btn-add-book { display:flex; align-items:center; gap:7px; padding:10px 20px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; border-radius:10px; font-size:13px; font-weight:700; text-decoration:none; transition:all 0.2s; border:none; cursor:pointer; font-family:'Inter',sans-serif; }
        .btn-add-book:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(124,58,237,0.4); }

        /* ALERT */
        .alert { padding:12px 18px; border-radius:12px; margin-bottom:24px; font-size:13px; display:flex; align-items:center; gap:8px; }
        .alert-success { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#6ee7b7; }
        .alert-error { background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#fca5a5; }

        /* STATS */
        .stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:28px; }
        @media(max-width:1100px) { .stats-grid { grid-template-columns:repeat(2,1fr); } }
        .stat-card { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:16px; padding:20px; transition:all 0.3s; position:relative; overflow:hidden; }
        .stat-card::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; border-radius:16px 16px 0 0; }
        .stat-card.purple::before { background:linear-gradient(90deg,#7c3aed,#a855f7); }
        .stat-card.green::before { background:linear-gradient(90deg,#059669,#34d399); }
        .stat-card.pink::before { background:linear-gradient(90deg,#db2777,#f472b6); }
        .stat-card.orange::before { background:linear-gradient(90deg,#d97706,#fb923c); }
        .stat-card:hover { border-color:rgba(255,255,255,0.15); transform:translateY(-2px); }
        .stat-top { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:14px; }
        .stat-icon-wrap { width:42px; height:42px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:18px; }
        .stat-icon-wrap.purple { background:rgba(124,58,237,0.15); }
        .stat-icon-wrap.green { background:rgba(5,150,105,0.15); }
        .stat-icon-wrap.pink { background:rgba(219,39,119,0.15); }
        .stat-icon-wrap.orange { background:rgba(217,119,6,0.15); }
        .stat-trend { font-size:11px; padding:3px 8px; border-radius:20px; font-weight:600; }
        .trend-up { background:rgba(52,211,153,0.1); color:#34d399; }
        .trend-neutral { background:rgba(255,255,255,0.05); color:rgba(255,255,255,0.35); }
        .stat-value { font-size:28px; font-weight:800; color:#fff; margin-bottom:4px; letter-spacing:-0.5px; }
        .stat-label { font-size:12px; color:rgba(255,255,255,0.38); font-weight:500; }

        /* QUICK ACTIONS */
        .quick-actions { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:28px; }
        .qa-btn { display:flex; flex-direction:column; align-items:center; gap:8px; padding:18px 12px; background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:14px; text-decoration:none; transition:all 0.2s; cursor:pointer; font-family:'Inter',sans-serif; }
        .qa-btn:hover { border-color:rgba(124,58,237,0.35); background:rgba(124,58,237,0.07); transform:translateY(-2px); }
        .qa-icon { font-size:22px; }
        .qa-label { font-size:12px; font-weight:600; color:rgba(255,255,255,0.6); text-align:center; }

        /* TWO COL */
        .two-col { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:28px; }
        @media(max-width:900px) { .two-col { grid-template-columns:1fr; } }

        /* CARD */
        .card { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:16px; overflow:hidden; }
        .card-header { padding:18px 22px; border-bottom:0.5px solid rgba(255,255,255,0.06); display:flex; justify-content:space-between; align-items:center; }
        .card-title { font-size:15px; font-weight:700; color:#fff; }
        .card-link { font-size:12px; color:#a78bfa; text-decoration:none; font-weight:600; }
        .card-link:hover { color:#c4b5fd; }

        /* TABLE */
        .tbl { width:100%; border-collapse:collapse; }
        .tbl th { padding:12px 18px; text-align:left; font-size:11px; font-weight:600; color:rgba(255,255,255,0.3); text-transform:uppercase; letter-spacing:0.7px; background:rgba(255,255,255,0.02); }
        .tbl td { padding:14px 18px; border-top:0.5px solid rgba(255,255,255,0.05); font-size:13px; }
        .tbl tr:hover td { background:rgba(255,255,255,0.02); }
        .book-title { font-weight:600; color:#fff; font-size:13px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:150px; }
        .book-author { font-size:11px; color:rgba(255,255,255,0.35); margin-top:2px; }
        .price-text { font-weight:700; color:#a78bfa; font-size:13px; }

        /* BADGES */
        .badge { display:inline-flex; align-items:center; gap:3px; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
        .badge-available { background:rgba(52,211,153,0.12); color:#34d399; border:0.5px solid rgba(52,211,153,0.25); }
        .badge-sold { background:rgba(239,68,68,0.12); color:#f87171; border:0.5px solid rgba(239,68,68,0.25); }
        .badge-pending { background:rgba(251,191,36,0.12); color:#fbbf24; border:0.5px solid rgba(251,191,36,0.25); }
        .badge-confirmed { background:rgba(96,165,250,0.12); color:#60a5fa; border:0.5px solid rgba(96,165,250,0.25); }
        .badge-shipped { background:rgba(167,139,250,0.12); color:#a78bfa; border:0.5px solid rgba(167,139,250,0.25); }
        .badge-delivered { background:rgba(52,211,153,0.12); color:#34d399; border:0.5px solid rgba(52,211,153,0.25); }
        .badge-cancelled { background:rgba(239,68,68,0.12); color:#f87171; border:0.5px solid rgba(239,68,68,0.25); }
        .badge-paid { background:rgba(52,211,153,0.12); color:#34d399; border:0.5px solid rgba(52,211,153,0.25); }
        .badge-unpaid { background:rgba(251,191,36,0.12); color:#fbbf24; border:0.5px solid rgba(251,191,36,0.25); }
        .badge-New { background:rgba(167,139,250,0.12); color:#c4b5fd; border:0.5px solid rgba(167,139,250,0.25); }
        .badge-Like { background:rgba(96,165,250,0.12); color:#93c5fd; border:0.5px solid rgba(96,165,250,0.25); }
        .badge-Good { background:rgba(52,211,153,0.12); color:#6ee7b7; border:0.5px solid rgba(52,211,153,0.25); }
        .badge-Fair { background:rgba(251,191,36,0.12); color:#fcd34d; border:0.5px solid rgba(251,191,36,0.25); }
        .badge-Poor { background:rgba(239,68,68,0.12); color:#fca5a5; border:0.5px solid rgba(239,68,68,0.25); }

        /* ACTION BTNS */
        .act-btn { padding:5px 12px; border-radius:7px; font-size:11px; font-weight:600; cursor:pointer; text-decoration:none; transition:all 0.2s; border:0.5px solid transparent; display:inline-flex; align-items:center; gap:4px; font-family:'Inter',sans-serif; }
        .btn-edit { background:rgba(251,191,36,0.1); color:#fbbf24; border-color:rgba(251,191,36,0.25); }
        .btn-edit:hover { background:rgba(251,191,36,0.2); }
        .btn-toggle { background:rgba(96,165,250,0.1); color:#60a5fa; border-color:rgba(96,165,250,0.25); }
        .btn-toggle:hover { background:rgba(96,165,250,0.2); }
        .btn-del { background:rgba(239,68,68,0.1); color:#f87171; border-color:rgba(239,68,68,0.25); }
        .btn-del:hover { background:rgba(239,68,68,0.2); }

        /* EMPTY */
        .empty { padding:40px; text-align:center; color:rgba(255,255,255,0.25); }
        .empty-icon { font-size:36px; margin-bottom:10px; }
        .empty p { font-size:13px; }

        /* PERF CHART */
        .perf-bars { padding:20px 22px; }
        .perf-row { display:flex; align-items:center; gap:10px; margin-bottom:12px; }
        .perf-label { font-size:12px; color:rgba(255,255,255,0.4); width:80px; flex-shrink:0; }
        .perf-bar-wrap { flex:1; height:8px; background:rgba(255,255,255,0.06); border-radius:4px; overflow:hidden; }
        .perf-bar { height:100%; border-radius:4px; transition:width 1s ease; }
        .perf-val { font-size:12px; color:rgba(255,255,255,0.5); width:40px; text-align:right; flex-shrink:0; }

        /* TIPS */
        .tips { padding:20px 22px; display:flex; flex-direction:column; gap:10px; }
        .tip { display:flex; align-items:flex-start; gap:10px; padding:12px; background:rgba(255,255,255,0.03); border:0.5px solid rgba(255,255,255,0.06); border-radius:10px; }
        .tip-icon { font-size:18px; flex-shrink:0; }
        .tip-title { font-size:12px; font-weight:700; color:#fff; margin-bottom:3px; }
        .tip-desc { font-size:11px; color:rgba(255,255,255,0.38); line-height:1.5; }

        /* FULL TABLE SECTION */
        .full-card { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:16px; overflow:hidden; margin-bottom:28px; }

        /* RATING STARS */
        .stars { color:#fbbf24; font-size:12px; letter-spacing:1px; }

        @media(max-width:768px) {
            .sidebar { display:none; }
            .main { margin-left:0; padding:20px 16px; }
            .stats-grid { grid-template-columns:repeat(2,1fr); }
            .quick-actions { grid-template-columns:repeat(2,1fr); }
        }
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
    <div class="sb-seller-info">
      <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
      <div class="sb-name">{{ auth()->user()->name }}</div>
      <div class="sb-role"><span class="sb-role-dot"></span> Seller Account</div>
    </div>
    <nav class="sb-nav">
      <div class="sb-section-label">Main</div>
      <a href="{{ route('seller.dashboard') }}" class="sb-link active">
        <span class="sb-link-icon">📊</span> Dashboard
      </a>
      <a href="{{ route('books.create') }}" class="sb-link">
        <span class="sb-link-icon">➕</span> Add New Book
      </a>
      

      <div class="sb-section-label" style="margin-top:8px;">My Store</div>
      <a href="{{ route('orders.received') }}" class="sb-link">
        <span class="sb-link-icon">📦</span> Orders
        @if(isset($pendingOrdersCount) && $pendingOrdersCount > 0)
          <span class="sb-link-badge">{{ $pendingOrdersCount }}</span>
        @endif
      </a>
      <a href="#my-listings" class="sb-link">
        <span class="sb-link-icon">📖</span> My Listings
      </a>

      <div class="sb-section-label" style="margin-top:8px;">Account</div>
      <a href="{{ route('seller.dashboard') }}" class="sb-link">
        <span class="sb-link-icon">👤</span> Profile
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
        <h1>Seller Dashboard 📊</h1>
        <p>{{ now()->format('l, d F Y') }} · Welcome back, {{ auth()->user()->name }}!</p>
      </div>
      <div class="topbar-right">
        <a href="{{ route('books.create') }}" class="btn-add-book">➕ Add New Book</a>
      </div>
    </div>

    <!-- ALERTS -->
    @if(session('success'))
      <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif

    <!-- STATS -->
    <div class="stats-grid">
      <div class="stat-card purple">
        <div class="stat-top">
          <div class="stat-icon-wrap purple">📚</div>
          <span class="stat-trend trend-neutral">Total</span>
        </div>
        <div class="stat-value">{{ $books->count() }}</div>
        <div class="stat-label">Books Listed</div>
      </div>
      <div class="stat-card green">
        <div class="stat-top">
          <div class="stat-icon-wrap green">✅</div>
          <span class="stat-trend trend-up">Active</span>
        </div>
        <div class="stat-value">{{ $books->where('status','available')->count() }}</div>
        <div class="stat-label">Available Books</div>
      </div>
      <div class="stat-card pink">
        <div class="stat-top">
          <div class="stat-icon-wrap pink">🛒</div>
          <span class="stat-trend trend-up">Sales</span>
        </div>
        <div class="stat-value">{{ $totalSales }}</div>
        <div class="stat-label">Total Orders</div>
      </div>
      <div class="stat-card orange">
        <div class="stat-top">
          <div class="stat-icon-wrap orange">💰</div>
          <span class="stat-trend trend-up">Earned</span>
        </div>
        <div class="stat-value">৳{{ number_format($totalEarnings,0) }}</div>
        <div class="stat-label">Total Earnings</div>
      </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="quick-actions">
      <a href="{{ route('books.create') }}" class="qa-btn">
        <span class="qa-icon">📝</span>
        <span class="qa-label">List a Book</span>
      </a>
      <a href="{{ route('orders.received') }}" class="qa-btn">
        <span class="qa-icon">📦</span>
        <span class="qa-label">View Orders</span>
      </a>
      
      <a href="{{ route('home') }}" class="qa-btn">
        <span class="qa-icon">🏠</span>
        <span class="qa-label">Go to Home</span>
      </a>
    </div>

    <!-- TWO COL -->
     <!-- ANALYTICS CHART -->
    <div class="full-card" style="margin-bottom:28px;">
      <div class="card-header">
        <span class="card-title">📈 Earnings Analytics — Last 6 Months</span>
      </div>
      <div style="padding:24px;">
        <canvas id="earningsChart" height="100"></canvas>
      </div>
    </div>
    <div class="two-col">

      <!-- RECENT ORDERS -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">📦 Recent Orders</span>
          <a href="{{ route('orders.received') }}" class="card-link">View all →</a>
        </div>
        @if($recentOrders->isEmpty())
          <div class="empty"><div class="empty-icon">📦</div><p>No orders yet</p></div>
        @else
          <table class="tbl">
            <thead><tr><th>Book</th><th>Price</th><th>Status</th></tr></thead>
            <tbody>
              @foreach($recentOrders->take(5) as $order)
                <tr>
                  <td>
                    <div class="book-title">{{ Str::limit($order->book->title ?? 'N/A', 22) }}</div>
                    <div class="book-author">{{ $order->buyer->name ?? '' }}</div>
                  </td>
                  <td><span class="price-text">৳{{ number_format($order->price,0) }}</span></td>
                  <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>

      <!-- SELLER TIPS -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">💡 Seller Tips</span>
        </div>
        <div class="tips">
          <div class="tip">
            <span class="tip-icon">📸</span>
            <div>
              <div class="tip-title">Add high quality photos</div>
              <div class="tip-desc">Books with clear photos sell 3x faster than those without.</div>
            </div>
          </div>
          <div class="tip">
            <span class="tip-icon">💰</span>
            <div>
              <div class="tip-title">Price competitively</div>
              <div class="tip-desc">Check similar books and price 10-15% lower to sell faster.</div>
            </div>
          </div>
          <div class="tip">
            <span class="tip-icon">📝</span>
            <div>
              <div class="tip-title">Write detailed descriptions</div>
              <div class="tip-desc">Include condition details, edition, and any highlights or notes.</div>
            </div>
          </div>
          <div class="tip">
            <span class="tip-icon">⚡</span>
            <div>
              <div class="tip-title">Respond quickly</div>
              <div class="tip-desc">Fast responses lead to better ratings and more sales.</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- MY BOOKS FULL TABLE -->
    <div class="full-card" id="my-listings">
      <div class="card-header">
        <span class="card-title">📖 My Book Listings</span>
        <a href="{{ route('books.create') }}" class="btn-add-book" style="font-size:12px;padding:8px 14px;">➕ Add Book</a>
      </div>
      @if($books->isEmpty())
        <div class="empty">
          <div class="empty-icon">📚</div>
          <p>No books listed yet! <a href="{{ route('books.create') }}" style="color:#a78bfa;">Add your first book →</a></p>
        </div>
      @else
        <table class="tbl">
          <thead>
            <tr>
              <th>Book</th>
              <th>Price</th>
              <th>Condition</th>
              <th>Rating</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($books as $book)
              @php $avg = round($book->reviews->avg('rating') ?? 0,1); @endphp
              <tr>
                <td>
                  <div class="book-title">{{ $book->title }}</div>
                  <div class="book-author">{{ $book->author }}</div>
                </td>
                <td><span class="price-text">৳{{ number_format($book->price,0) }}</span></td>
                <td>
                  @php $condKey = explode(' ',$book->condition)[0]; @endphp
                  <span class="badge badge-{{ $condKey }}">{{ $book->condition }}</span>
                </td>
                <td>
                  <span class="stars">
                    @for($i=1;$i<=5;$i++){{ $i<=round($avg)?'★':'☆' }}@endfor
                  </span>
                  <span style="font-size:11px;color:rgba(255,255,255,0.3);"> ({{ $book->reviews->count() }})</span>
                </td>
                <td><span class="badge badge-{{ $book->status }}">{{ ucfirst($book->status) }}</span></td>
                <td>
                  <div style="display:flex;gap:5px;flex-wrap:wrap;">
                    <a href="{{ route('books.edit',$book) }}" class="act-btn btn-edit">✏️ Edit</a>
                    <form method="POST" action="{{ route('seller.toggle',$book) }}" style="margin:0;">
                      @csrf @method('PATCH')
                      <button type="submit" class="act-btn btn-toggle">
                        {{ $book->status==='available'?'🔴 Sold':'🟢 Available' }}
                      </button>
                    </form>
                    <form method="POST" action="{{ route('books.destroy',$book) }}" style="margin:0;" onsubmit="return confirm('Delete this book?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="act-btn btn-del">🗑️ Delete</button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>

  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('earningsChart').getContext('2d');
const months = @json(array_column($monthlyEarnings, 'month'));
const earnings = @json(array_column($monthlyEarnings, 'earning'));

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Earnings (৳)',
            data: earnings,
            backgroundColor: 'rgba(124,58,237,0.3)',
            borderColor: 'rgba(124,58,237,0.8)',
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
        }, {
            label: 'Trend',
            data: earnings,
            type: 'line',
            borderColor: '#a78bfa',
            borderWidth: 2,
            pointBackgroundColor: '#a78bfa',
            pointRadius: 4,
            tension: 0.4,
            fill: false,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: { color: 'rgba(255,255,255,0.5)', font: { family: 'Inter' } }
            },
            tooltip: {
                backgroundColor: '#1a1a2e',
                titleColor: '#fff',
                bodyColor: 'rgba(255,255,255,0.7)',
                borderColor: 'rgba(124,58,237,0.3)',
                borderWidth: 1,
                callbacks: {
                    label: ctx => '৳' + ctx.parsed.y.toLocaleString()
                }
            }
        },
        scales: {
            x: {
                ticks: { color: 'rgba(255,255,255,0.4)', font: { family: 'Inter' } },
                grid: { color: 'rgba(255,255,255,0.05)' }
            },
            y: {
                ticks: {
                    color: 'rgba(255,255,255,0.4)',
                    font: { family: 'Inter' },
                    callback: val => '৳' + val
                },
                grid: { color: 'rgba(255,255,255,0.05)' }
            }
        }
    }
});
</script>

</body>
</html>
