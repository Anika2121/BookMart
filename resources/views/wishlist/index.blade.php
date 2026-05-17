<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>??</text></svg>">
    <title>My Wishlist - BookMart</title>
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
        .page { max-width:1100px; margin:0 auto; padding:36px 24px; }
        .page-header { margin-bottom:28px; }
        .page-header h1 { font-size:28px; font-weight:800; margin-bottom:6px; }
        .page-header p { color:rgba(255,255,255,0.4); font-size:14px; }

        /* Alerts */
        .alert { padding:12px 18px; border-radius:12px; margin-bottom:20px; font-size:14px; display:flex; align-items:center; gap:8px; }
        .alert-success { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#6ee7b7; }
        .alert-error { background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#fca5a5; }

        /* Book Grid */
        .book-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(230px,1fr)); gap:20px; }

        /* Book Card */
        .book-card { background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:16px; overflow:hidden; transition:all 0.3s; position:relative; }
        .book-card:hover { transform:translateY(-6px); border-color:rgba(239,68,68,0.3); box-shadow:0 16px 40px rgba(0,0,0,0.4); }
        .book-img-wrap { position:relative; overflow:hidden; }
        .book-img { width:100%; height:210px; object-fit:cover; transition:transform 0.4s; }
        .book-card:hover .book-img { transform:scale(1.05); }
        .book-placeholder { width:100%; height:210px; background:linear-gradient(135deg,rgba(124,58,237,0.15),rgba(168,85,247,0.1)); display:flex; align-items:center; justify-content:center; font-size:52px; }

        /* Condition Badge */
        .cond-badge { position:absolute; top:10px; left:10px; padding:3px 8px; border-radius:6px; font-size:10px; font-weight:700; backdrop-filter:blur(8px); }
        .cond-new { background:rgba(52,211,153,0.2); color:#6ee7b7; border:1px solid rgba(52,211,153,0.3); }
        .cond-like { background:rgba(96,165,250,0.2); color:#93c5fd; border:1px solid rgba(96,165,250,0.3); }
        .cond-good { background:rgba(251,191,36,0.2); color:#fcd34d; border:1px solid rgba(251,191,36,0.3); }
        .cond-fair { background:rgba(251,146,60,0.2); color:#fdba74; border:1px solid rgba(251,146,60,0.3); }
        .cond-poor { background:rgba(239,68,68,0.2); color:#fca5a5; border:1px solid rgba(239,68,68,0.3); }

        /* Remove btn */
        .remove-btn { position:absolute; top:10px; right:10px; width:32px; height:32px; border-radius:50%; background:rgba(239,68,68,0.2); border:1px solid rgba(239,68,68,0.3); display:flex; align-items:center; justify-content:center; font-size:14px; cursor:pointer; transition:all 0.2s; }
        .remove-btn:hover { background:rgba(239,68,68,0.4); transform:scale(1.1); }

        /* Sold overlay */
        .sold-overlay { position:absolute; inset:0; background:rgba(0,0,0,0.6); display:flex; align-items:center; justify-content:center; }
        .sold-text { font-size:22px; font-weight:900; color:#f87171; transform:rotate(-15deg); border:2px solid #f87171; padding:6px 16px; border-radius:6px; }

        .book-body { padding:14px; }
        .book-title { font-size:14px; font-weight:700; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:3px; }
        .book-author { font-size:12px; color:rgba(255,255,255,0.4); margin-bottom:8px; }
        .book-rating { font-size:12px; color:#fbbf24; margin-bottom:8px; }
        .book-footer { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
        .book-price { font-size:18px; font-weight:800; background:linear-gradient(135deg,#a78bfa,#f472b6); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .book-status-sold { font-size:12px; color:#f87171; font-weight:600; }
        .book-actions { display:flex; gap:6px; }
        .btn-view { flex:1; padding:9px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; border:none; border-radius:8px; font-size:12px; font-weight:700; text-decoration:none; text-align:center; transition:all 0.2s; cursor:pointer; font-family:'Inter',sans-serif; }
        .btn-view:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(124,58,237,0.4); }
        .btn-cart { padding:9px 10px; background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); border-radius:8px; font-size:12px; cursor:pointer; font-family:'Inter',sans-serif; color:#6ee7b7; transition:all 0.2s; white-space:nowrap; }
        .btn-cart:hover { background:rgba(52,211,153,0.2); }
        .btn-cart-disabled { padding:9px 10px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:8px; font-size:12px; color:rgba(255,255,255,0.2); cursor:not-allowed; }

        /* Empty */
        .empty-state { text-align:center; padding:80px 20px; }
        .empty-icon { font-size:64px; margin-bottom:16px; }
        .empty-title { font-size:20px; font-weight:700; margin-bottom:8px; }
        .empty-sub { font-size:14px; color:rgba(255,255,255,0.4); margin-bottom:24px; }
        .btn-browse { padding:12px 28px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; border-radius:12px; text-decoration:none; font-weight:700; font-size:14px; transition:all 0.2s; display:inline-block; }
        .btn-browse:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(124,58,237,0.4); }

        /* Count badge */
        .count-badge { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:20px; font-size:13px; font-weight:600; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#f87171; margin-bottom:20px; }
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
        <a href="{{ route('orders.my') }}" class="nav-link">📦 Orders</a>
        <a href="{{ route('wishlist.index') }}" class="nav-link active">❤️ Wishlist</a>
        <a href="{{ route('cart.index') }}" class="nav-link">🛒 Cart</a>
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
        <h1>❤️ My Wishlist</h1>
        <p>Save books here that you want to buy later</p>
    </div>

    @if($wishlists->count() > 0)
        <div class="count-badge">
            ❤️ {{ $wishlists->count() }} Book added to wishlist
        </div>

        <div class="book-grid">
            @foreach($wishlists as $wishlist)
                @php
                    $book = $wishlist->book;
                    $avgRating = round($book->reviews->avg('rating') ?? 0, 1);
                    $condClass = match($book->condition) {
                        'New' => 'cond-new', 'Like New' => 'cond-like',
                        'Good' => 'cond-good', 'Fair' => 'cond-fair', default => 'cond-poor',
                    };
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

                        <span class="cond-badge {{ $condClass }}">{{ $book->condition }}</span>

                        {{-- Remove from Wishlist --}}
                        <form method="POST" action="{{ route('wishlist.toggle', $book->id) }}" style="display:contents;">
                            @csrf
                            <button type="submit" class="remove-btn" title="Remove from wishlist">🗑️</button>
                        </form>

                        {{-- Sold Overlay --}}
                        @if($book->status === 'sold')
                            <div class="sold-overlay"><div class="sold-text">SOLD</div></div>
                        @endif
                    </div>

                    <div class="book-body">
                        <div class="book-title">{{ $book->title }}</div>
                        <div class="book-author">by {{ $book->author }}</div>
                        @if($avgRating > 0)
                            <div class="book-rating">
                                @for($i=1;$i<=5;$i++){{ $i <= $avgRating ? '⭐' : '☆' }}@endfor
                                {{ $avgRating }}
                            </div>
                        @endif
                        <div class="book-footer">
                            <span class="book-price">৳{{ number_format($book->price, 0) }}</span>
                            @if($book->status === 'sold')
                                <span class="book-status-sold">❌ Sold</span>
                            @endif
                        </div>
                        <div class="book-actions">
                            <a href="{{ route('books.show', $book) }}" class="btn-view">View →</a>
                            @if($book->status === 'available')
                                <form method="POST" action="{{ route('cart.add', $book) }}">
                                    @csrf
                                    <button type="submit" class="btn-cart">🛒 Add to Cart</button>
                                </form>
                            @else
                                <span class="btn-cart-disabled">Unavailable</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        <div class="empty-state">
            <div class="empty-icon">❤️</div>
            <div class="empty-title">Wishlist Empty</div>
            <div class="empty-sub">Save your favorite books to the wishlist</div>
            <a href="{{ route('books.index') }}" class="btn-browse">📚 Browse Books</a>
        </div>
    @endif

</div>
</body>
</html>