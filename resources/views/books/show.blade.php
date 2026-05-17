<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
    <title>{{ $book->title }} - BookMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#0a0a0f; color:#fff; min-height:100vh; }
        ::-webkit-scrollbar { width:5px; }
        ::-webkit-scrollbar-thumb { background:rgba(124,58,237,0.4); border-radius:4px; }

        .navbar { position:sticky; top:0; z-index:100; background:rgba(10,10,15,0.95); backdrop-filter:blur(20px); border-bottom:1px solid rgba(255,255,255,0.06); padding:14px 32px; display:flex; justify-content:space-between; align-items:center; }
        .nav-brand { display:flex; align-items:center; gap:10px; text-decoration:none; }
        .nav-brand-icon { width:34px; height:34px; border-radius:9px; background:linear-gradient(135deg,#7c3aed,#4f46e5); display:flex; align-items:center; justify-content:center; font-size:15px; }
        .nav-brand-name { font-size:17px; font-weight:900; color:#fff; }
        .nav-brand-name span { background:linear-gradient(135deg,#a78bfa,#60a5fa); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .nav-links { display:flex; align-items:center; gap:6px; }
        .nav-link { padding:7px 14px; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600; color:rgba(255,255,255,0.6); transition:all 0.2s; border:none; cursor:pointer; font-family:'Inter',sans-serif; background:transparent; }
        .nav-link:hover { background:rgba(255,255,255,0.06); color:#fff; }
        .nav-link-primary { background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff !important; }
        .nav-link-danger { background:rgba(239,68,68,0.1); color:#f87171 !important; border:1px solid rgba(239,68,68,0.2); }
        .nav-link-danger:hover { background:rgba(239,68,68,0.2); }

        .breadcrumb { max-width:1100px; margin:0 auto; padding:16px 24px 0; display:flex; align-items:center; gap:8px; font-size:13px; color:rgba(255,255,255,0.35); flex-wrap:wrap; }
        .breadcrumb a { color:rgba(255,255,255,0.35); text-decoration:none; transition:color 0.2s; }
        .breadcrumb a:hover { color:#a78bfa; }

        .page { max-width:1100px; margin:0 auto; padding:24px; }

        .alert { padding:12px 18px; border-radius:12px; margin-bottom:20px; font-size:14px; display:flex; align-items:center; gap:8px; }
        .alert-success { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#6ee7b7; }
        .alert-error { background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#fca5a5; }

        /* BOOK LAYOUT */
        .book-layout { display:grid; grid-template-columns:340px 1fr; gap:36px; margin-bottom:48px; }
        @media(max-width:800px) { .book-layout { grid-template-columns:1fr; } }

        /* LEFT - IMAGE */
        .book-cover-wrap { position:relative; }
        .book-cover { width:100%; border-radius:18px; overflow:hidden; background:linear-gradient(135deg,rgba(124,58,237,0.15),rgba(168,85,247,0.1)); aspect-ratio:3/4; display:flex; align-items:center; justify-content:center; border:1px solid rgba(255,255,255,0.08); position:relative; }
        .book-cover img { width:100%; height:100%; object-fit:cover; }
        .book-cover-placeholder { font-size:80px; }
        .cond-badge { position:absolute; top:14px; left:14px; padding:5px 12px; border-radius:20px; font-size:12px; font-weight:700; backdrop-filter:blur(8px); }
        .cond-New { background:rgba(52,211,153,0.2); color:#6ee7b7; border:1px solid rgba(52,211,153,0.3); }
        .cond-Like { background:rgba(96,165,250,0.2); color:#93c5fd; border:1px solid rgba(96,165,250,0.3); }
        .cond-Good { background:rgba(251,191,36,0.2); color:#fcd34d; border:1px solid rgba(251,191,36,0.3); }
        .cond-Fair { background:rgba(251,146,60,0.2); color:#fdba74; border:1px solid rgba(251,146,60,0.3); }
        .cond-Poor { background:rgba(239,68,68,0.2); color:#fca5a5; border:1px solid rgba(239,68,68,0.3); }
        .sold-overlay { position:absolute; inset:0; background:rgba(0,0,0,0.6); display:flex; align-items:center; justify-content:center; border-radius:18px; }
        .sold-text { font-size:28px; font-weight:900; color:#f87171; transform:rotate(-15deg); border:3px solid #f87171; padding:8px 20px; border-radius:8px; }

        .img-actions { display:flex; gap:8px; margin-top:12px; }
        .btn-wishlist { flex:1; padding:12px; border-radius:12px; border:none; cursor:pointer; font-family:'Inter',sans-serif; font-size:13px; font-weight:700; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:6px; }
        .btn-wishlist-add { background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2); }
        .btn-wishlist-add:hover { background:rgba(239,68,68,0.2); }
        .btn-wishlist-remove { background:rgba(239,68,68,0.25); color:#fca5a5; border:1px solid rgba(239,68,68,0.4); }
        .btn-compare { padding:12px 16px; border-radius:12px; border:1px solid rgba(255,255,255,0.1); background:rgba(255,255,255,0.05); color:rgba(255,255,255,0.6); font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .btn-compare:hover { background:rgba(124,58,237,0.15); border-color:rgba(124,58,237,0.3); color:#a78bfa; }

        /* RIGHT - INFO */
        .book-cat-tag { display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; background:rgba(124,58,237,0.1); color:#a78bfa; border:1px solid rgba(124,58,237,0.2); margin-bottom:12px; text-decoration:none; }
        .book-title { font-size:32px; font-weight:900; line-height:1.15; margin-bottom:8px; }
        .book-author-line { font-size:15px; color:rgba(255,255,255,0.5); margin-bottom:16px; }
        .book-author-line span { color:#a78bfa; font-weight:600; }

        .rating-row { display:flex; align-items:center; gap:12px; margin-bottom:20px; }
        .stars { color:#fbbf24; font-size:18px; letter-spacing:1px; }
        .rating-num { font-size:18px; font-weight:800; }
        .rating-count { font-size:13px; color:rgba(255,255,255,0.4); }

        .price-section { margin-bottom:22px; }
        .book-price { font-size:42px; font-weight:900; background:linear-gradient(135deg,#a78bfa,#f472b6); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }

        .meta-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:22px; }
        .meta-item { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:10px; padding:10px 14px; }
        .meta-label { font-size:11px; color:rgba(255,255,255,0.35); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:3px; }
        .meta-value { font-size:13px; font-weight:600; color:#fff; }

        .buy-section { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px; }
        .btn-buy { flex:1; min-width:180px; padding:15px 26px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; border:none; border-radius:13px; font-size:15px; font-weight:800; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.3s; box-shadow:0 6px 24px rgba(124,58,237,0.4); text-decoration:none; text-align:center; display:flex; align-items:center; justify-content:center; gap:8px; }
        .btn-buy:hover { transform:translateY(-2px); box-shadow:0 10px 32px rgba(124,58,237,0.6); }
        .btn-buy-disabled { background:rgba(255,255,255,0.08); color:rgba(255,255,255,0.3); cursor:not-allowed; box-shadow:none; }
        .btn-buy-disabled:hover { transform:none; box-shadow:none; }
        .btn-cart { flex:1; min-width:140px; padding:15px 20px; background:rgba(52,211,153,0.12); border:1px solid rgba(52,211,153,0.25); color:#34d399; border-radius:13px; font-size:14px; font-weight:700; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:7px; text-decoration:none; }
        .btn-cart:hover { background:rgba(52,211,153,0.2); }
        .btn-login-buy { flex:1; min-width:180px; padding:15px 26px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.12); color:#fff; border-radius:13px; font-size:14px; font-weight:700; text-decoration:none; text-align:center; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:7px; }
        .btn-login-buy:hover { background:rgba(255,255,255,0.1); }

        .seller-card { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:14px; padding:16px; display:flex; align-items:center; gap:14px; }
        .seller-av { width:44px; height:44px; border-radius:50%; background:linear-gradient(135deg,#7c3aed,#4f46e5); display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:800; flex-shrink:0; overflow:hidden; }
        .seller-av img { width:100%; height:100%; object-fit:cover; }
        .seller-name { font-size:14px; font-weight:700; }
        .seller-sub { font-size:12px; color:rgba(255,255,255,0.4); margin-top:2px; }

        /* TABS */
        .tabs-section { margin-bottom:36px; }
        .tabs { display:flex; gap:4px; border-bottom:1px solid rgba(255,255,255,0.08); margin-bottom:24px; }
        .tab-btn { padding:12px 20px; border:none; background:transparent; color:rgba(255,255,255,0.4); font-size:14px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; border-bottom:2px solid transparent; margin-bottom:-1px; transition:all 0.2s; }
        .tab-btn.active { color:#a78bfa; border-bottom-color:#a78bfa; }
        .tab-btn:hover { color:rgba(255,255,255,0.7); }
        .tab-content { display:none; }
        .tab-content.active { display:block; }

        .desc-text { font-size:15px; color:rgba(255,255,255,0.65); line-height:1.85; }

        /* REVIEWS */
        .review-card { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:14px; padding:18px; margin-bottom:12px; }
        .review-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px; }
        .reviewer-name { font-size:14px; font-weight:700; }
        .review-stars { color:#fbbf24; font-size:14px; }
        .review-date { font-size:11px; color:rgba(255,255,255,0.3); margin-top:3px; }
        .review-text { font-size:13px; color:rgba(255,255,255,0.6); line-height:1.65; margin-top:8px; }

        .review-form-card { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08); border-radius:14px; padding:22px; margin-top:22px; }
        .review-form-card h3 { font-size:15px; font-weight:700; margin-bottom:16px; }
        .field-label { display:block; font-size:11px; font-weight:600; color:rgba(255,255,255,0.4); margin-bottom:7px; text-transform:uppercase; letter-spacing:0.5px; }
        .field-input { width:100%; padding:10px 14px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08); border-radius:9px; color:#fff; font-size:14px; font-family:'Inter',sans-serif; outline:none; transition:all 0.2s; }
        .field-input:focus { border-color:rgba(124,58,237,0.5); background:rgba(124,58,237,0.05); }
        .field-input option { background:#1a1a2e; }
        .btn-submit-review { padding:11px 24px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:700; cursor:pointer; font-family:'Inter',sans-serif; margin-top:12px; transition:all 0.2s; }
        .btn-submit-review:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(124,58,237,0.4); }

        /* RECOMMENDED */
        .sec-title { font-size:20px; font-weight:800; margin-bottom:16px; }
        .rec-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(175px,1fr)); gap:14px; }
        .rec-card { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:13px; overflow:hidden; text-decoration:none; transition:all 0.2s; }
        .rec-card:hover { border-color:rgba(124,58,237,0.3); transform:translateY(-3px); }
        .rec-img { width:100%; height:115px; object-fit:cover; }
        .rec-placeholder { width:100%; height:115px; background:linear-gradient(135deg,rgba(124,58,237,0.1),rgba(168,85,247,0.08)); display:flex; align-items:center; justify-content:center; font-size:30px; }
        .rec-body { padding:10px 12px; }
        .rec-title { font-size:12px; font-weight:700; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .rec-price { font-size:12px; color:#a78bfa; font-weight:700; margin-top:3px; }

        @media(max-width:600px) {
            .navbar { padding:12px 16px; }
            .page { padding:16px; }
            .book-title { font-size:24px; }
            .book-price { font-size:32px; }
            .meta-grid { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar">
    <a href="{{ route('home') }}" class="nav-brand">
        <div class="nav-brand-icon">📚</div>
        <div class="nav-brand-name">Book<span>Mart</span></div>
    </a>
    <div class="nav-links">
        @auth
            @if(auth()->user()->isBuyer())
                <a href="{{ route('buyer.dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('cart.index') }}" class="nav-link">🛒 Cart</a>
                <a href="{{ route('wishlist.index') }}" class="nav-link">♡ Wishlist</a>
            @elseif(auth()->user()->isSeller())
                <a href="{{ route('seller.dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('books.create') }}" class="nav-link nav-link-primary">+ Sell Book</a>
            @elseif(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="nav-link">⚡ Admin</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="nav-link nav-link-danger">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="nav-link">Login</a>
            <a href="{{ route('register') }}" class="nav-link nav-link-primary">Register</a>
        @endauth
    </div>
</nav>

{{-- BREADCRUMB --}}
<div class="breadcrumb">
    <a href="{{ route('books.index') }}">📚 Books</a>
    <span>›</span>
    @if($book->category)
        <a href="{{ route('books.index',['category'=>$book->category_id]) }}">{{ $book->category->name }}</a>
        <span>›</span>
    @endif
    <span style="color:rgba(255,255,255,0.6);">{{ Str::limit($book->title,40) }}</span>
</div>

<div class="page">

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif

    <div class="book-layout">

        {{-- LEFT: IMAGE --}}
        <div class="book-cover-wrap">
            <div class="book-cover">
                @if($book->image)
                    <img src="{{ Storage::url($book->image) }}" alt="{{ $book->title }}">
                @else
                    <div class="book-cover-placeholder">📚</div>
                @endif
                @php $condKey = explode(' ',$book->condition)[0]; @endphp
                <span class="cond-badge cond-{{ $condKey }}">{{ $book->condition }}</span>
                @if($book->status === 'sold')
                    <div class="sold-overlay"><div class="sold-text">SOLD</div></div>
                @endif
            </div>

            @auth
                @if(auth()->user()->isBuyer())
                    <div class="img-actions">
                        <form method="POST" action="{{ route('wishlist.toggle',$book) }}" style="flex:1;">
                            @csrf
                            <button type="submit" class="btn-wishlist {{ in_array($book->id, $wishlistIds ?? []) ? 'btn-wishlist-remove' : 'btn-wishlist-add' }}" style="width:100%;">
                                {{ in_array($book->id, $wishlistIds ?? []) ? '❤️ Wishlisted' : '🤍 Add to Wishlist' }}
                            </button>
                        </form>
                    </div>
                @endif
                @if(auth()->user()->isSeller() && $book->user_id === auth()->id())
                    <div style="display:flex;gap:8px;margin-top:12px;">
                        <a href="{{ route('books.edit',$book) }}" class="btn-cart" style="color:#a78bfa;border-color:rgba(124,58,237,0.3);background:rgba(124,58,237,0.1);">✏️ Edit</a>
                        <form method="POST" action="{{ route('books.destroy',$book) }}" onsubmit="return confirm('Delete this book?')" style="flex:1;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-cart" style="width:100%;color:#f87171;border-color:rgba(239,68,68,0.25);background:rgba(239,68,68,0.1);">🗑️ Delete</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>

        {{-- RIGHT: INFO --}}
        <div>
            @if($book->category)
                <a href="{{ route('books.index',['category'=>$book->category_id]) }}" class="book-cat-tag">
                    📂 {{ $book->category->name }}
                </a>
            @endif

            <h1 class="book-title">{{ $book->title }}</h1>
            <div class="book-author-line">
                by <span>{{ $book->author }}</span>
                @if($book->publisher) · {{ $book->publisher }} @endif
                @if($book->published_year) · {{ $book->published_year }} @endif
            </div>

            @php $avgRating = $book->averageRating(); @endphp
            <div class="rating-row">
                <div class="stars">
                    @for($i=1;$i<=5;$i++){{ $i <= round($avgRating) ? '★' : '☆' }}@endfor
                </div>
                <span class="rating-num">{{ number_format($avgRating,1) }}</span>
                <span class="rating-count">({{ $book->reviews->count() }} reviews)</span>
            </div>

            <div class="price-section">
                <div class="book-price">৳{{ number_format($book->price,0) }}</div>
            </div>

            <div class="meta-grid">
                <div class="meta-item">
                    <div class="meta-label">Language</div>
                    <div class="meta-value">{{ $book->language ?? 'Not specified' }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Condition</div>
                    <div class="meta-value">{{ $book->condition }}</div>
                </div>
                @if($book->publisher)
                <div class="meta-item">
                    <div class="meta-label">Publisher</div>
                    <div class="meta-value">{{ $book->publisher }}</div>
                </div>
                @endif
                @if($book->published_year)
                <div class="meta-item">
                    <div class="meta-label">Year</div>
                    <div class="meta-value">{{ $book->published_year }}</div>
                </div>
                @endif
                <div class="meta-item">
                    <div class="meta-label">Status</div>
                    <div class="meta-value" style="color:{{ $book->status === 'available' ? '#34d399' : '#f87171' }};">
                        {{ $book->status === 'available' ? '✅ Available' : '❌ Sold' }}
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Views</div>
                    <div class="meta-value">👁️ {{ $book->view_count ?? 0 }}</div>
                </div>
            </div>

            {{-- BUY BUTTONS --}}
            @auth
                @if(auth()->user()->isBuyer())
                    @if($book->status === 'available')
                        <div class="buy-section">
                            <form method="POST" action="{{ route('orders.store',$book) }}" style="flex:1;display:flex;">
                                @csrf
                                <button type="submit" class="btn-buy" onclick="return confirm('Confirm purchase of {{ addslashes($book->title) }} for ৳{{ number_format($book->price,0) }}?')">
                                    🛍️ Buy Now — ৳{{ number_format($book->price,0) }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('cart.add',$book) }}" style="display:flex;">
                                @csrf
                                <button type="submit" class="btn-cart">🛒 Add to Cart</button>
                            </form>
                        </div>
                    @else
                        <div class="buy-section">
                            <button class="btn-buy btn-buy-disabled">❌ Book Sold Out</button>
                        </div>
                    @endif
                @elseif(auth()->user()->isSeller() && $book->user_id !== auth()->id())
                    <div class="buy-section">
                        <div class="btn-login-buy" style="cursor:default;">🚫 Sellers cannot buy books</div>
                    </div>
                @endif
            @else
                <div class="buy-section">
                    <a href="{{ route('login') }}" class="btn-buy">🔐 Login to Buy</a>
                    <a href="{{ route('register') }}" class="btn-cart" style="color:#a78bfa;border-color:rgba(124,58,237,0.3);background:rgba(124,58,237,0.1);">📝 Register</a>
                </div>
            @endauth

            {{-- SELLER --}}
            <div class="seller-card">
                <div class="seller-av">
                    @if($book->user->photo ?? $book->user->avatar ?? null)
                        <img src="{{ Storage::url($book->user->photo ?? $book->user->avatar) }}" alt="{{ $book->user->name }}">
                    @else
                        {{ strtoupper(substr($book->user->name,0,1)) }}
                    @endif
                </div>
                <div>
                    <div class="seller-name">{{ $book->user->name }}</div>
                    <div class="seller-sub">✅ Verified Seller · Member since {{ $book->user->created_at->format('M Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABS --}}
    <div class="tabs-section">
        <div class="tabs">
            <button class="tab-btn active" onclick="showTab('desc',this)">📖 Description</button>
            <button class="tab-btn" onclick="showTab('reviews',this)">⭐ Reviews ({{ $book->reviews->count() }})</button>
        </div>

        <div class="tab-content active" id="tab-desc">
            @if($book->description)
                <p class="desc-text">{{ $book->description }}</p>
            @else
                <p style="color:rgba(255,255,255,0.3);font-size:14px;">No description provided.</p>
            @endif
        </div>

        <div class="tab-content" id="tab-reviews">
            @if($book->reviews->count() > 0)
                @foreach($book->reviews as $review)
                    <div class="review-card">
                        <div class="review-header">
                            <div>
                                <div class="reviewer-name">{{ $review->user->name ?? 'Anonymous' }}</div>
                                <div class="review-date">{{ $review->created_at->format('d M Y') }}</div>
                            </div>
                            <div class="review-stars">
                                @for($i=1;$i<=5;$i++){{ $i<=$review->rating ? '★' : '☆' }}@endfor
                            </div>
                        </div>
                        @if($review->comment)
                            <div class="review-text">{{ $review->comment }}</div>
                        @endif
                    </div>
                @endforeach
            @else
                <p style="color:rgba(255,255,255,0.3);font-size:14px;padding:20px 0;">No reviews yet. Be the first to review!</p>
            @endif

            @auth
                @if(auth()->user()->isBuyer())
                    <div class="review-form-card">
                        <h3>✍️ Write a Review</h3>
                        <form method="POST" action="{{ route('reviews.store',$book->id) }}">
                            @csrf
                            <div style="margin-bottom:12px;">
                                <label class="field-label">Rating</label>
                                <select name="rating" class="field-input" required>
                                    <option value="">Select rating</option>
                                    @for($i=5;$i>=1;$i--)
                                        <option value="{{ $i }}">{{ str_repeat('★',$i) }} ({{ $i }}/5)</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label class="field-label">Comment (optional)</label>
                                <textarea name="comment" class="field-input" rows="3" placeholder="Share your thoughts about this book..."></textarea>
                            </div>
                            <button type="submit" class="btn-submit-review">📝 Submit Review</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    {{-- RECOMMENDED --}}
    @if(isset($relatedBooks) && $relatedBooks->count() > 0)
        <div style="margin-bottom:40px;">
            <div class="sec-title">📚 You Might Also Like</div>
            <div class="rec-grid">
                @foreach($relatedBooks as $rel)
                    <a href="{{ route('books.show',$rel) }}" class="rec-card">
                        @if($rel->image)
                            <img src="{{ Storage::url($rel->image) }}" alt="{{ $rel->title }}" class="rec-img" loading="lazy">
                        @else
                            <div class="rec-placeholder">📚</div>
                        @endif
                        <div class="rec-body">
                            <div class="rec-title">{{ $rel->title }}</div>
                            <div class="rec-price">৳{{ number_format($rel->price,0) }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>

<script>
function showTab(id, btn) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + id).classList.add('active');
    btn.classList.add('active');
}
</script>
</body>
</html>