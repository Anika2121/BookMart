<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
    <title>Received Orders — BookMart</title>
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

        .topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; }
        .topbar h1 { font-size:22px; font-weight:700; color:#fff; letter-spacing:-0.4px; }
        .topbar p { font-size:13px; color:rgba(255,255,255,0.35); margin-top:3px; }

        .alert { padding:12px 18px; border-radius:12px; margin-bottom:24px; font-size:13px; display:flex; align-items:center; gap:8px; }
        .alert-success { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#6ee7b7; }

        /* STATS */
        .stats-row { display:grid; grid-template-columns:repeat(5,1fr); gap:14px; margin-bottom:24px; }
        @media(max-width:1100px) { .stats-row { grid-template-columns:repeat(3,1fr); } }
        .stat { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:14px; padding:16px 18px; }
        .stat-val { font-size:24px; font-weight:800; }
        .stat-label { font-size:11px; color:rgba(255,255,255,0.3); margin-top:4px; font-weight:500; text-transform:uppercase; letter-spacing:0.5px; }

        /* CARD */
        .card { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:16px; overflow:hidden; }
        .card-header { padding:18px 24px; border-bottom:0.5px solid rgba(255,255,255,0.06); display:flex; align-items:center; justify-content:space-between; }
        .card-title { font-size:15px; font-weight:700; color:#fff; }
        .card-count { font-size:12px; color:rgba(255,255,255,0.3); }

        /* SEARCH */
        .search-bar { padding:16px 24px; border-bottom:0.5px solid rgba(255,255,255,0.06); display:flex; gap:10px; }
        .search-input { flex:1; padding:9px 14px; background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.1); border-radius:9px; color:#fff; font-size:13px; outline:none; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .search-input:focus { border-color:rgba(124,58,237,0.5); background:rgba(124,58,237,0.05); }
        .search-input::placeholder { color:rgba(255,255,255,0.2); }
        .filter-select { padding:9px 14px; background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.1); border-radius:9px; color:#fff; font-size:13px; outline:none; font-family:'Inter',sans-serif; cursor:pointer; }
        .filter-select option { background:#0f0f1e; }

        /* TABLE */
        table { width:100%; border-collapse:collapse; }
        thead tr { border-bottom:0.5px solid rgba(255,255,255,0.06); }
        th { padding:12px 20px; text-align:left; font-size:11px; font-weight:600; letter-spacing:0.8px; text-transform:uppercase; color:rgba(255,255,255,0.3); background:rgba(255,255,255,0.02); }
        tbody tr { border-bottom:0.5px solid rgba(255,255,255,0.04); transition:background 0.15s; }
        tbody tr:hover { background:rgba(255,255,255,0.02); }
        td { padding:14px 20px; font-size:13px; vertical-align:middle; }

        .book-title { font-weight:600; color:#fff; margin-bottom:3px; }
        .book-addr { font-size:11px; color:rgba(255,255,255,0.3); max-width:180px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .buyer-name { font-weight:500; color:#fff; margin-bottom:3px; }
        .buyer-email { font-size:11px; color:rgba(255,255,255,0.3); }
        .order-id { font-family:monospace; font-size:12px; color:rgba(255,255,255,0.3); background:rgba(255,255,255,0.04); padding:3px 8px; border-radius:5px; }
        .price { font-weight:700; color:#a78bfa; font-size:14px; }

        /* BADGES */
        .badge { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600; }
        .badge::before { content:''; width:6px; height:6px; border-radius:50%; }
        .badge-pending { background:rgba(251,191,36,0.12); color:#fbbf24; }
        .badge-pending::before { background:#fbbf24; }
        .badge-confirmed { background:rgba(96,165,250,0.12); color:#60a5fa; }
        .badge-confirmed::before { background:#60a5fa; }
        .badge-shipped { background:rgba(167,139,250,0.12); color:#a78bfa; }
        .badge-shipped::before { background:#a78bfa; }
        .badge-delivered { background:rgba(52,211,153,0.12); color:#34d399; }
        .badge-delivered::before { background:#34d399; }
        .badge-cancelled { background:rgba(239,68,68,0.12); color:#f87171; }
        .badge-cancelled::before { background:#f87171; }

        /* STATUS SELECT */
        .status-select { padding:7px 10px; background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; font-size:12px; font-weight:500; outline:none; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.15s; }
        .status-select:hover { border-color:rgba(124,58,237,0.4); }
        .status-select option { background:#0f0f1e; }

        /* EMPTY */
        .empty { text-align:center; padding:60px 24px; }
        .empty-icon { font-size:40px; margin-bottom:12px; }
        .empty-title { font-size:15px; font-weight:600; color:rgba(255,255,255,0.4); margin-bottom:6px; }
        .empty-sub { font-size:13px; color:rgba(255,255,255,0.2); }

        @media(max-width:768px) { .sidebar { display:none; } .main { margin-left:0; padding:20px 16px; } }
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
      <a href="{{ route('seller.dashboard') }}" class="sb-link">
        <span class="sb-link-icon">📊</span> Dashboard
      </a>
      <a href="{{ route('books.create') }}" class="sb-link">
        <span class="sb-link-icon">➕</span> Add New Book
      </a>
      <div class="sb-section-label" style="margin-top:8px;">My Store</div>
      <a href="{{ route('orders.received') }}" class="sb-link active">
        <span class="sb-link-icon">📦</span> Orders
        @php $pendingCount = $orders->where('status','pending')->count(); @endphp
        @if($pendingCount > 0)
          <span class="sb-link-badge">{{ $pendingCount }}</span>
        @endif
      </a>
      <a href="{{ route('seller.dashboard') }}#my-listings" class="sb-link">
        <span class="sb-link-icon">📖</span> My Listings
      </a>
      <div class="sb-section-label" style="margin-top:8px;">Account</div>
      <a href="{{ route('seller.profile') }}" class="sb-link">
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
    <div class="topbar">
      <div>
        <h1>📦 Received Orders</h1>
        <p>Manage and update orders placed for your books</p>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <!-- STATS -->
    <div class="stats-row">
      <div class="stat">
        <div class="stat-val" style="color:#fff;">{{ $orders->count() }}</div>
        <div class="stat-label">Total</div>
      </div>
      <div class="stat">
        <div class="stat-val" style="color:#fbbf24;">{{ $orders->where('status','pending')->count() }}</div>
        <div class="stat-label">Pending</div>
      </div>
      <div class="stat">
        <div class="stat-val" style="color:#60a5fa;">{{ $orders->where('status','confirmed')->count() }}</div>
        <div class="stat-label">Confirmed</div>
      </div>
      <div class="stat">
        <div class="stat-val" style="color:#a78bfa;">{{ $orders->where('status','shipped')->count() }}</div>
        <div class="stat-label">Shipped</div>
      </div>
      <div class="stat">
        <div class="stat-val" style="color:#34d399;">{{ $orders->where('status','delivered')->count() }}</div>
        <div class="stat-label">Delivered</div>
      </div>
    </div>

    <!-- TABLE -->
    <div class="card">
      <div class="card-header">
        <span class="card-title">All Received Orders</span>
        <span class="card-count">{{ $orders->count() }} orders</span>
      </div>
      <div class="search-bar">
        <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search by book title or buyer...">
        <select class="filter-select" id="statusFilter">
          <option value="">All Status</option>
          <option value="pending">Pending</option>