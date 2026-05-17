<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>??</text></svg>">
    <title>BookMart - Buy & Sell Books</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#0a0a0f; color:#fff; min-height:100vh; overflow-x:hidden; }

        /* Ambient Orbs */
        body::before { content:''; position:fixed; width:600px; height:600px; background:radial-gradient(circle,rgba(124,58,237,0.12),transparent 70%); top:-200px; left:-200px; border-radius:50%; pointer-events:none; z-index:0; animation:orb1 12s ease-in-out infinite; }
        body::after { content:''; position:fixed; width:500px; height:500px; background:radial-gradient(circle,rgba(236,72,153,0.08),transparent 70%); bottom:-100px; right:-100px; border-radius:50%; pointer-events:none; z-index:0; animation:orb2 14s ease-in-out infinite; }
        @keyframes orb1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(60px,80px)} }
        @keyframes orb2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-40px,-60px)} }

        /* Navbar */
        .navbar { position:sticky; top:0; z-index:200; background:rgba(10,10,15,0.92); backdrop-filter:blur(20px); border-bottom:1px solid rgba(255,255,255,0.06); padding:0 32px; display:flex; flex-direction:column; }
        .navbar-top { display:flex; justify-content:space-between; align-items:center; padding:14px 0; }
        .nav-brand { display:flex; align-items:center; gap:10px; text-decoration:none; }
        .nav-brand-icon { width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,#7c3aed,#4f46e5); display:flex; align-items:center; justify-content:center; font-size:16px; }
        .nav-brand-name { font-size:18px; font-weight:900; color:#fff; }
        .nav-brand-name span { background:linear-gradient(135deg,#a78bfa,#60a5fa); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .nav-actions { display:flex; align-items:center; gap:8px; }
        .nav-btn { padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none; border:none; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; color:rgba(255,255,255,0.6); background:transparent; }
        .nav-btn:hover { background:rgba(255,255,255,0.06); color:#fff; }
        .nav-btn-primary { background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff !important; box-shadow:0 4px 15px rgba(124,58,237,0.3); }
        .nav-btn-primary:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(124,58,237,0.5); }
        .nav-btn-danger { background:rgba(239,68,68,0.1); color:#f87171 !important; border:1px solid rgba(239,68,68,0.2); }
        .nav-btn-danger:hover { background:rgba(239,68,68,0.2); }

        /* Category Nav Bar */
        .cat-nav { display:flex; gap:4px; padding:10px 0; border-top:1px solid rgba(255,255,255,0.05); overflow-x:auto; scrollbar-width:none; }
        .cat-nav::-webkit-scrollbar { display:none; }
        .cat-nav-btn { padding:6px 16px; border-radius:20px; font-size:12px; font-weight:600; white-space:nowrap; text-decoration:none; color:rgba(255,255,255,0.5); border:1px solid transparent; transition:all 0.2s; cursor:pointer; background:transparent; font-family:'Inter',sans-serif; }
        .cat-nav-btn:hover { color:#fff; background:rgba(255,255,255,0.06); }
        .cat-nav-btn.active { color:#a78bfa; background:rgba(124,58,237,0.12); border-color:rgba(124,58,237,0.3); }

        /* Main */
        .main { position:relative; z-index:1; max-width:1280px; margin:0 auto; padding:28px 24px; }

        /* Alerts */
        .alert { padding:12px 18px; border-radius:12px; margin-bottom:20px; font-size:14px; display:flex; align-items:center; gap:8px; }
        .alert-success { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#6ee7b7; }
        .alert-error { background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#fca5a5; }

        /* Search & Filter */
        .search-wrap { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:16px; padding:18px 20px; margin-bottom:28px; }
        .search-row { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:12px; }
        .filter-row { display:flex; gap:10px; flex-wrap:wrap; align-items:center; }
        .search-input { flex:1; min-width:240px; padding:11px 16px 11px 42px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); border-radius:10px; color:#fff; font-size:14px; font-family:'Inter',sans-serif; outline:none; transition:all 0.3s; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='rgba(255,255,255,0.3)' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:14px center; }
        .search-input::placeholder { color:rgba(255,255,255,0.25); }
        .search-input:focus { border-color:rgba(124,58,237,0.6); background-color:rgba(124,58,237,0.06); }
        .filter-select { padding:10px 32px 10px 14px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); border-radius:10px; color:#fff; font-size:13px; font-family:'Inter',sans-serif; outline:none; cursor:pointer; transition:all 0.3s; appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='rgba(255,255,255,0.4)' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 10px center; background-color:rgba(255,255,255,0.06); }
        .filter-select option { background:#1a1a2e; }
        .price-input { width:100px; padding:10px 12px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); border-radius:10px; color:#fff; font-size:13px; font-family:'Inter',sans-serif; outline:none; }
        .price-input::placeholder { color:rgba(255,255,255,0.25); }
        .btn-search { padding:11px 22px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:700; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .btn-search:hover { transform:translateY(-1px); }
        .btn-reset { padding:11px 16px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); border-radius:10px; color:rgba(255,255,255,0.6); font-size:13px; font-weight:600; text-decoration:none; transition:all 0.2s; }
        .btn-reset:hover { background:rgba(255,255,255,0.1); color:#fff; }

        /* Section */
        .section { margin-bottom:40px; }
        .section-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; }
        .section-title { font-size:18px; font-weight:800; display:flex; align-items:center; gap:8px; }
        .section-badge { font-size:11px; font-weight:700; padding:3px 10px; border-radius:20px; }
        .badge-fire { background:rgba(251,146,60,0.15); color:#fdba74; border:1px solid rgba(251,146,60,0.25); }
        .badge-new { background:rgba(52,211,153,0.15); color:#6ee7b7; border:1px solid rgba(52,211,153,0.25); }
        .badge-star { background:rgba(251,191,36,0.15); color:#fcd34d; border:1px solid rgba(251,191,36,0.25); }
        .badge-featured { background:rgba(124,58,237,0.15); color:#a78bfa; border:1px solid rgba(124,58,237,0.25); }
        .section-link { font-size:13px; color:#a78bfa; text-decoration:none; font-weight:600; }
        .section-link:hover { color:#c4b5fd; }

        /* Horizontal Scroll Grid */
        .h-scroll { display:flex; gap:14px; overflow-x:auto; padding-bottom:8px; scrollbar-width:none; }
        .h-scroll::-webkit-scrollbar { display:none; }

        /* Featured Banner Cards */
        .featured-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:16px; }
        .featured-card { background:linear-gradient(135deg,rgba(124,58,237,0.15),rgba(168,85,247,0.08)); border:1px solid rgba(124,58,237,0.25); border-radius:16px; padding:18px; display:flex; gap:14px; align-items:center; transition:all 0.3s; text-decoration:none; }
        .featured-card:hover { transform:translateY(-3px); border-color:rgba(124,58,237,0.5); box-shadow:0 12px 30px rgba(124,58,237,0.2); }
        .featured-img { width:70px; height:90px; object-fit:cover; border-radius:8px; flex-shrink:0; }
        .featured-placeholder { width:70px; height:90px; border-radius:8px; background:rgba(124,58,237,0.2); display:flex; align-items:center; justify-content:center; font-size:28px; flex-shrink:0; }
        .featured-info { flex:1; min-width:0; }
        .featured-badge { font-size:10px; font-weight:700; color:#a78bfa; background:rgba(124,58,237,0.15); padding:2px 8px; border-radius:20px; display:inline-block; margin-bottom:6px; }
        .featured-title { font-size:14px; font-weight:700; color:#fff; margin-bottom:3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .featured-author { font-size:12px; color:rgba(255,255,255,0.45); margin-bottom:6px; }
        .featured-price { font-size:16px; font-weight:800; background:linear-gradient(135deg,#a78bfa,#f472b6); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }

        /* Small Book Cards (horizontal scroll) */
        .book-card-sm { background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:14px; overflow:hidden; transition:all 0.3s; flex-shrink:0; width:170px; text-decoration:none; display:block; }
        .book-card-sm:hover { transform:translateY(-4px); border-color:rgba(124,58,237,0.3); box-shadow:0 10px 25px rgba(0,0,0,0.4); }
        .book-card-sm-img { width:100%; height:180px; object-fit:cover; }
        .book-card-sm-placeholder { width:100%; height:180px; background:linear-gradient(135deg,rgba(124,58,237,0.15),rgba(168,85,247,0.1)); display:flex; align-items:center; justify-content:center; font-size:40px; }
        .book-card-sm-body { padding:10px 12px; }
        .book-card-sm-title { font-size:13px; font-weight:700; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:2px; }
        .book-card-sm-author { font-size:11px; color:rgba(255,255,255,0.4); margin-bottom:6px; }
        .book-card-sm-footer { display:flex; justify-content:space-between; align-items:center; }
        .book-card-sm-price { font-size:14px; font-weight:800; background:linear-gradient(135deg,#a78bfa,#f472b6); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .book-card-sm-rating { font-size:11px; color:#fbbf24; }
        .rank-badge { position:absolute; top:8px; left:8px; width:24px; height:24px; border-radius:50%; background:linear-gradient(135deg,#f59e0b,#ef4444); display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:900; color:#fff; }

        /* Main Book Grid */
        .divider-section { margin:32px 0 24px; border-top:1px solid rgba(255,255,255,0.06); padding-top:28px; }
        .results-bar { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; flex-wrap:wrap; gap:10px; }
        .results-count { font-size:14px; color:rgba(255,255,255,0.5); }
        .results-count span { color:#a78bfa; font-weight:700; }

        .book-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:18px; }
        .book-card { background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:16px; overflow:hidden; transition:all 0.3s; position:relative; }
        .book-card:hover { transform:translateY(-6px); border-color:rgba(124,58,237,0.35); box-shadow:0 16px 40px rgba(0,0,0,0.4); }
        .book-img-wrap { position:relative; overflow:hidden; }
        .book-img { width:100%; height:200px; object-fit:cover; transition:transform 0.4s; }
        .book-card:hover .book-img { transform:scale(1.05); }
        .book-placeholder { width:100%; height:200px; background:linear-gradient(135deg,rgba(124,58,237,0.15),rgba(168,85,247,0.1)); display:flex; align-items:center; justify-content:center; font-size:48px; }
        .book-badges { position:absolute; top:8px; left:8px; display:flex; flex-direction:column; gap:4px; }
        .badge { padding:3px 8px; border-radius:6px; font-size:10px; font-weight:700; backdrop-filter:blur(8px); }
        .badge-new-book { background:rgba(52,211,153,0.2); color:#6ee7b7; border:1px solid rgba(52,211,153,0.3); }
        .badge-like { background:rgba(96,165,250,0.2); color:#93c5fd; border:1px solid rgba(96,165,250,0.3); }
        .badge-good { background:rgba(251,191,36,0.2); color:#fcd34d; border:1px solid rgba(251,191,36,0.3); }
        .badge-fair { background:rgba(251,146,60,0.2); color:#fdba74; border:1px solid rgba(251,146,60,0.3); }
        .badge-poor { background:rgba(239,68,68,0.2); color:#fca5a5; border:1px solid rgba(239,68,68,0.3); }
        .badge-featured-card { background:rgba(124,58,237,0.25); color:#c4b5fd; border:1px solid rgba(124,58,237,0.4); }
        .wishlist-btn { position:absolute; top:8px; right:8px; width:30px; height:30px; border-radius:50%; background:rgba(0,0,0,0.5); backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,0.1); display:flex; align-items:center; justify-content:center; font-size:13px; cursor:pointer; transition:all 0.2s; }
        .wishlist-btn:hover { background:rgba(239,68,68,0.3); transform:scale(1.1); }
        .book-body { padding:12px 14px; }
        .book-title { font-size:14px; font-weight:700; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:2px; }
        .book-author { font-size:12px; color:rgba(255,255,255,0.4); margin-bottom:6px; }
        .book-meta { display:flex; align-items:center; gap:6px; margin-bottom:8px; flex-wrap:wrap; }
        .book-rating { font-size:11px; color:#fbbf24; }
        .book-views { font-size:11px; color:rgba(255,255,255,0.3); }
        .book-lang { font-size:10px; padding:2px 6px; border-radius:4px; background:rgba(96,165,250,0.1); color:#93c5fd; border:1px solid rgba(96,165,250,0.2); }
        .book-footer2 { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
        .book-price { font-size:16px; font-weight:800; background:linear-gradient(135deg,#a78bfa,#f472b6); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .book-orders { font-size:11px; color:rgba(255,255,255,0.3); }
        .book-actions { display:flex; gap:6px; }
        .btn-view-book { flex:1; padding:8px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; border:none; border-radius:8px; font-size:12px; font-weight:700; text-decoration:none; text-align:center; transition:all 0.2s; cursor:pointer; font-family:'Inter',sans-serif; }
        .btn-view-book:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(124,58,237,0.4); }
        .btn-compare-add { padding:8px 10px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); border-radius:8px; font-size:12px; cursor:pointer; font-family:'Inter',sans-serif; color:rgba(255,255,255,0.6); transition:all 0.2s; }
        .btn-compare-add:hover { background:rgba(124,58,237,0.15); border-color:rgba(124,58,237,0.3); color:#a78bfa; }
        .btn-compare-add.in-compare { background:rgba(124,58,237,0.2); border-color:rgba(124,58,237,0.4); color:#a78bfa; }

        /* Compare Bar */
        .compare-bar { position:fixed; bottom:24px; left:50%; transform:translateX(-50%); background:rgba(15,15,26,0.95); backdrop-filter:blur(20px); border:1px solid rgba(124,58,237,0.4); border-radius:16px; padding:14px 24px; display:flex; align-items:center; gap:16px; z-index:300; box-shadow:0 8px 40px rgba(0,0,0,0.5); min-width:400px; }
        .compare-bar-title { font-size:13px; font-weight:700; color:#a78bfa; }
        .compare-items { display:flex; gap:8px; flex:1; }
        .compare-item { padding:6px 12px; background:rgba(124,58,237,0.15); border:1px solid rgba(124,58,237,0.3); border-radius:8px; font-size:12px; color:#c4b5fd; max-width:120px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .btn-compare-now { padding:8px 18px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; font-family:'Inter',sans-serif; text-decoration:none; white-space:nowrap; }
        .btn-compare-clear { padding:8px 14px; background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2); border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; }

        /* Recently Viewed */
        .recent-card { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:12px; overflow:hidden; text-decoration:none; transition:all 0.2s; flex-shrink:0; width:150px; display:block; }
        .recent-card:hover { border-color:rgba(124,58,237,0.3); transform:translateY(-3px); }
        .recent-img { width:100%; height:90px; object-fit:cover; }
        .recent-placeholder { width:100%; height:90px; background:linear-gradient(135deg,rgba(124,58,237,0.1),rgba(168,85,247,0.08)); display:flex; align-items:center; justify-content:center; font-size:24px; }
        .recent-body { padding:8px 10px; }
        .recent-title { font-size:12px; font-weight:700; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .recent-price { font-size:11px; color:#a78bfa; font-weight:700; margin-top:2px; }

        /* Empty */
        .empty-state { text-align:center; padding:60px 20px; color:rgba(255,255,255,0.35); }
        .empty-state .icon { font-size:56px; margin-bottom:14px; }

        /* Pagination */
        .pagination-wrap { margin-top:32px; display:flex; justify-content:center; }

        /* Score indicator */
        .score-bar { height:3px; border-radius:2px; background:rgba(255,255,255,0.06); margin-top:6px; overflow:hidden; }
        .score-fill { height:100%; border-radius:2px; background:linear-gradient(90deg,#7c3aed,#a855f7); transition:width 0.3s; }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <div class="navbar-top">
        <a href="{{ route('home') }}" class="nav-brand">
            <div class="nav-brand-icon">📚</div>
            <div class="nav-brand-name">Book<span>Mart</span></div>
        </a>
        <div class="nav-actions">
            @auth
                @if(auth()->user()->isBuyer())
                    <a href="{{ route('buyer.dashboard') }}" class="nav-btn">Dashboard</a>
                    <a href="{{ route('wishlist.index') }}" class="nav-btn">❤️ Wishlist</a>
                    <a href="{{ route('orders.my') }}" class="nav-btn">📦 Orders</a>
                    <a href="{{ route('cart.index') }}" class="nav-btn">🛒 Cart</a>
                @elseif(auth()->user()->isSeller())
                    <a href="{{ route('seller.dashboard') }}" class="nav-btn">Dashboard</a>
                    <a href="{{ route('books.create') }}" class="nav-btn nav-btn-primary">+ Sell Book</a>
                @elseif(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-btn">Admin Panel</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="nav-btn nav-btn-danger">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-btn">Login</a>
                <a href="{{ route('register') }}" class="nav-btn nav-btn-primary">Get Started</a>
            @endauth
        </div>
    </div>

    {{-- Category Nav --}}
    <div class="cat-nav">
        <a href="{{ route('books.index', request()->except('page','category')) }}"
           class="cat-nav-btn {{ !request('category') && !request('sort') ? 'active' : '' }}">
            All Books
        </a>
        <a href="{{ route('books.index', array_merge(request()->except('page','sort'), ['sort' => 'best_sellers'])) }}"
           class="cat-nav-btn {{ request('sort') == 'best_sellers' ? 'active' : '' }}">
            🔥 Best Sellers
        </a>
        <a href="{{ route('books.index', array_merge(request()->except('page','sort'), ['sort' => 'newest'])) }}"
           class="cat-nav-btn {{ request('sort') == 'newest' ? 'active' : '' }}">
            ✨ New Arrivals
        </a>
        <a href="{{ route('books.index', array_merge(request()->except('page','sort'), ['sort' => 'rating'])) }}"
           class="cat-nav-btn {{ request('sort') == 'rating' ? 'active' : '' }}">
            ⭐ Top Rated
        </a>
        <a href="{{ route('books.index', array_merge(request()->except('page','sort'), ['sort' => 'most_viewed'])) }}"
           class="cat-nav-btn {{ request('sort') == 'most_viewed' ? 'active' : '' }}">
            👁️ Most Viewed
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('books.index', array_merge(request()->except('page','category'), ['category' => $cat->id])) }}"
               class="cat-nav-btn {{ request('category') == $cat->id ? 'active' : '' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>
</nav>

<div class="main">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('books.index') }}" class="search-wrap">
        <input type="hidden" name="category" value="{{ request('category') }}">
        <div class="search-row">
            <input type="text" name="search" class="search-input"
                   value="{{ request('search') }}"
                   placeholder="Search by title, author, ISBN, publisher...">
            <button type="submit" class="btn-search">🔍 Search</button>
            <a href="{{ route('books.index') }}" class="btn-reset">↺ Reset</a>
        </div>
        <div class="filter-row">
            <select name="condition" class="filter-select">
                <option value="">All Conditions</option>
                @foreach(['New','Like New','Good','Fair','Poor'] as $cond)
                    <option value="{{ $cond }}" {{ request('condition') == $cond ? 'selected' : '' }}>{{ $cond }}</option>
                @endforeach
            </select>

            <select name="language" class="filter-select">
                <option value="">All Languages</option>
                @foreach($languages as $lang)
                    <option value="{{ $lang }}" {{ request('language') == $lang ? 'selected' : '' }}>{{ $lang }}</option>
                @endforeach
            </select>

            <select name="min_rating" class="filter-select">
                <option value="">Any Rating</option>
                @foreach([4,3,2,1] as $r)
                    <option value="{{ $r }}" {{ request('min_rating') == $r ? 'selected' : '' }}>⭐ {{ $r }}+</option>
                @endforeach
            </select>

            <input type="number" name="min_price" class="price-input"
                   value="{{ request('min_price') }}" placeholder="Min ৳">
            <span style="color:rgba(255,255,255,0.3); font-size:13px;">—</span>
            <input type="number" name="max_price" class="price-input"
                   value="{{ request('max_price') }}" placeholder="Max ৳">

            <select name="sort" class="filter-select">
                <option value="">Smart Ranking</option>
                <option value="best_sellers"  {{ request('sort') == 'best_sellers'  ? 'selected' : '' }}>🔥 Best Sellers</option>
                <option value="newest"        {{ request('sort') == 'newest'        ? 'selected' : '' }}>✨ Newest First</option>
                <option value="rating"        {{ request('sort') == 'rating'        ? 'selected' : '' }}>⭐ Top Rated</option>
                <option value="most_viewed"   {{ request('sort') == 'most_viewed'   ? 'selected' : '' }}>👁️ Most Viewed</option>
                <option value="price_asc"     {{ request('sort') == 'price_asc'     ? 'selected' : '' }}>Price: Low → High</option>
                <option value="price_desc"    {{ request('sort') == 'price_desc'    ? 'selected' : '' }}>Price: High → Low</option>
            </select>
        </div>
    </form>

    {{-- Featured Books --}}
    @if($featuredBooks->count() > 0 && !request('search') && !request('sort') && !request('category'))
        <div class="section">
            <div class="section-header">
                <div class="section-title">
                    ⭐ Featured Books
                    <span class="section-badge badge-featured">Editor's Pick</span>
                </div>
            </div>
            <div class="featured-grid">
                @foreach($featuredBooks as $book)
                    <a href="{{ route('books.show', $book) }}" class="featured-card">
                        @if($book->image)
                            <img src="{{ Storage::url($book->image) }}" alt="{{ $book->title }}" class="featured-img">
                        @else
                            <div class="featured-placeholder">📚</div>
                        @endif
                        <div class="featured-info">
                            <span class="featured-badge">⭐ Featured</span>
                            <div class="featured-title">{{ $book->title }}</div>
                            <div class="featured-author">{{ $book->author }}</div>
                            <div class="featured-price">৳{{ number_format($book->price, 0) }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Best Sellers --}}
    @if($bestSellers->count() > 0 && !request('search') && !request('sort') && !request('category'))
        <div class="section">
            <div class="section-header">
                <div class="section-title">
                    🔥 Best Sellers
                    <span class="section-badge badge-fire">Trending</span>
                </div>
                <a href="{{ route('books.index', ['sort' => 'best_sellers']) }}" class="section-link">See all →</a>
            </div>
            <div class="h-scroll">
                @foreach($bestSellers as $i => $book)
                    @php $avg = round($book->reviews->avg('rating') ?? 0, 1); @endphp
                    <a href="{{ route('books.show', $book) }}" class="book-card-sm" style="position:relative;">
                        <div style="position:relative;">
                            @if($book->image)
                                <img src="{{ Storage::url($book->image) }}" alt="{{ $book->title }}" class="book-card-sm-img">
                            @else
                                <div class="book-card-sm-placeholder">📚</div>
                            @endif
                            <div class="rank-badge">#{{ $i + 1 }}</div>
                        </div>
                        <div class="book-card-sm-body">
                            <div class="book-card-sm-title">{{ $book->title }}</div>
                            <div class="book-card-sm-author">{{ $book->author }}</div>
                            <div class="book-card-sm-footer">
                                <span class="book-card-sm-price">৳{{ number_format($book->price, 0) }}</span>
                                @if($avg > 0)<span class="book-card-sm-rating">⭐ {{ $avg }}</span>@endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- New Arrivals --}}
    @if(!request('search') && !request('sort') && !request('category'))
        <div class="section">
            <div class="section-header">
                <div class="section-title">
                    ✨ New Arrivals
                    <span class="section-badge badge-new">Just Listed</span>
                </div>
                <a href="{{ route('books.index', ['sort' => 'newest']) }}" class="section-link">See all →</a>
            </div>
            <div class="h-scroll">
                @foreach($newArrivals as $book)
                    @php $avg = round($book->reviews->avg('rating') ?? 0, 1); @endphp
                    <a href="{{ route('books.show', $book) }}" class="book-card-sm">
                        @if($book->image)
                            <img src="{{ Storage::url($book->image) }}" alt="{{ $book->title }}" class="book-card-sm-img">
                        @else
                            <div class="book-card-sm-placeholder">📚</div>
                        @endif
                        <div class="book-card-sm-body">
                            <div class="book-card-sm-title">{{ $book->title }}</div>
                            <div class="book-card-sm-author">{{ $book->author }}</div>
                            <div class="book-card-sm-footer">
                                <span class="book-card-sm-price">৳{{ number_format($book->price, 0) }}</span>
                                <span style="font-size:10px; color:rgba(255,255,255,0.3);">{{ $book->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Top Rated --}}
    @if($topRated->count() > 0 && !request('search') && !request('sort') && !request('category'))
        <div class="section">
            <div class="section-header">
                <div class="section-title">
                    ⭐ Top Rated
                    <span class="section-badge badge-star">Highest Rated</span>
                </div>
                <a href="{{ route('books.index', ['sort' => 'rating']) }}" class="section-link">See all →</a>
            </div>
            <div class="h-scroll">
                @foreach($topRated as $book)
                    @php $avg = round($book->reviews->avg('rating') ?? 0, 1); @endphp
                    <a href="{{ route('books.show', $book) }}" class="book-card-sm">
                        @if($book->image)
                            <img src="{{ Storage::url($book->image) }}" alt="{{ $book->title }}" class="book-card-sm-img">
                        @else
                            <div class="book-card-sm-placeholder">📚</div>
                        @endif
                        <div class="book-card-sm-body">
                            <div class="book-card-sm-title">{{ $book->title }}</div>
                            <div class="book-card-sm-author">{{ $book->author }}</div>
                            <div class="book-card-sm-footer">
                                <span class="book-card-sm-price">৳{{ number_format($book->price, 0) }}</span>
                                @if($avg > 0)<span class="book-card-sm-rating">⭐ {{ $avg }}</span>@endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Recently Viewed --}}
    @php
        $recentIds   = session()->get('recently_viewed', []);
        $recentBooks = $recentIds
            ? \App\Models\Book::whereIn('id', $recentIds)
                ->where('status','available')
                ->get()
                ->sortBy(fn($b) => array_search($b->id, $recentIds))
            : collect();
    @endphp
    @if($recentBooks->count() > 0)
        <div class="section">
            <div class="section-header">
                <div class="section-title">🕐 Recently Viewed</div>
            </div>
            <div class="h-scroll">
                @foreach($recentBooks as $rb)
                    <a href="{{ route('books.show', $rb) }}" class="recent-card">
                        @if($rb->image)
                            <img src="{{ Storage::url($rb->image) }}" alt="{{ $rb->title }}" class="recent-img">
                        @else
                            <div class="recent-placeholder">📚</div>
                        @endif
                        <div class="recent-body">
                            <div class="recent-title">{{ $rb->title }}</div>
                            <div class="recent-price">৳{{ number_format($rb->price, 0) }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- All Books Grid --}}
    <div class="divider-section">
        <div class="results-bar">
            <div class="results-count">
                <span>{{ $books->total() }}</span> books found
                @if(request('search')) for "<strong>{{ request('search') }}</strong>" @endif
            </div>
            <div style="font-size:12px; color:rgba(255,255,255,0.3);">
                {{ request('sort') ? ucfirst(str_replace('_', ' ', request('sort'))) : 'Smart Ranking' }}
            </div>
        </div>

        @if($books->count() > 0)
            <div class="book-grid">
                @foreach($books as $book)
                    @php
                        $avg       = round($book->reviews->avg('rating') ?? 0, 1);
                        $inCompare = in_array($book->id, $compareList);
                        $condClass = match($book->condition) {
                            'New'      => 'badge-new-book',
                            'Like New' => 'badge-like',
                            'Good'     => 'badge-good',
                            'Fair'     => 'badge-fair',
                            default    => 'badge-poor',
                        };
                        $scorePercent = min(100, ($book->score / 100) * 100);
                    @endphp
                    <div class="book-card">
                        <div class="book-img-wrap">
                            <a href="{{ route('books.show', $book) }}">
                                @if($book->image)
                                    <img src="{{ Storage::url($book->image) }}" alt="{{ $book->title }}" class="book-img">
                                @else
                                    <div class="book-placeholder">📚</div>
                                @endif
                            </a>
                            <div class="book-badges">
                                <span class="badge {{ $condClass }}">{{ $book->condition }}</span>
                                @if($book->is_featured)
                                    <span class="badge badge-featured-card">⭐ Featured</span>
                                @endif
                            </div>
                            @auth
                                @if(auth()->user()->isBuyer())
                                    <form method="POST" action="{{ route('wishlist.toggle', $book->id) }}" style="display:contents;">
                                        @csrf
                                        <button type="submit" class="wishlist-btn">❤️</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                        <div class="book-body">
                            <div class="book-title">{{ $book->title }}</div>
                            <div class="book-author">{{ $book->author }}</div>
                            <div class="book-meta">
                                @if($avg > 0)
                                    <span class="book-rating">⭐ {{ $avg }}</span>
                                @endif
                                @if($book->language)
                                    <span class="book-lang">{{ $book->language }}</span>
                                @endif
                                @if($book->view_count > 0)
                                    <span class="book-views">👁️ {{ $book->view_count }}</span>
                                @endif
                            </div>
                            <div class="book-footer2">
                                <span class="book-price">৳{{ number_format($book->price, 0) }}</span>
                                @if($book->order_count > 0)
                                    <span class="book-orders">🛒 {{ $book->order_count }} sold</span>
                                @endif
                            </div>
                            {{-- Smart Score Bar --}}
                            <div class="score-bar">
                                <div class="score-fill" style="width:{{ $scorePercent }}%"></div>
                            </div>
                            <div class="book-actions" style="margin-top:10px;">
                                <a href="{{ route('books.show', $book) }}" class="btn-view-book">View →</a>
                                @if($inCompare)
                                    <form method="POST" action="{{ route('books.compare.remove', $book) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-compare-add in-compare">⚖️✓</button>
                                    </form>
                                @elseif(count($compareList) < 3)
                                    <form method="POST" action="{{ route('books.compare.add', $book) }}">
                                        @csrf
                                        <button type="submit" class="btn-compare-add">⚖️</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination-wrap">{{ $books->links() }}</div>
        @else
            <div class="empty-state">
                <div class="icon">🔍</div>
                <p style="font-size:16px; margin-bottom:6px;">No books found</p>
                <small>Try different keywords or filters</small>
            </div>
        @endif
    </div>

</div>

{{-- Compare Bar --}}
@if(count($compareList) >= 2)
    @php $compareBooks = \App\Models\Book::whereIn('id', $compareList)->get(); @endphp
    <div class="compare-bar">
        <span class="compare-bar-title">⚖️ Compare</span>
        <div class="compare-items">
            @foreach($compareBooks as $cb)
                <span class="compare-item">{{ $cb->title }}</span>
            @endforeach
        </div>
        <a href="{{ route('books.compare') }}" class="btn-compare-now">Compare Now →</a>
        <form method="POST" action="{{ route('books.compare.remove', $compareBooks->first()) }}">
            @csrf @method('DELETE')
            <button type="submit" class="btn-compare-clear">✕ Clear</button>
        </form>
    </div>
@endif

</body>
</html>