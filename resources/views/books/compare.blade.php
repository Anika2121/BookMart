<div>
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Maria Skłodowska-Curie -->
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>??</text></svg>">
    <title>Compare Books - BookMart</title>
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

        /* Page */
        .page { max-width:1200px; margin:0 auto; padding:32px 24px; }
        .page-header { margin-bottom:32px; text-align:center; }
        .page-header h1 { font-size:28px; font-weight:800; margin-bottom:8px; }
        .page-header p { color:rgba(255,255,255,0.4); font-size:14px; }

        /* Compare Table */
        .compare-wrap { overflow-x:auto; }
        .compare-table { width:100%; border-collapse:separate; border-spacing:0; }

        /* Header row */
        .compare-table .book-header { background:rgba(255,255,255,0.03); }
        .compare-table th { padding:0; vertical-align:top; }
        .label-col { width:180px; min-width:160px; }
        .book-col { min-width:240px; }

        .label-cell {
            padding:20px 16px;
            background:rgba(255,255,255,0.02);
            border-right:1px solid rgba(255,255,255,0.06);
            font-size:13px; font-weight:700; color:rgba(255,255,255,0.5);
            text-transform:uppercase; letter-spacing:0.5px;
            vertical-align:middle;
        }

        .book-header-cell {
            padding:20px; text-align:center;
            border-right:1px solid rgba(255,255,255,0.06);
            border-bottom:2px solid rgba(124,58,237,0.3);
        }
        .book-header-cell:last-child { border-right:none; }

        .book-cover-compare {
            width:120px; height:160px; object-fit:cover;
            border-radius:10px; margin:0 auto 12px;
            display:block;
        }
        .book-cover-placeholder-compare {
            width:120px; height:160px;
            background:linear-gradient(135deg,rgba(124,58,237,0.2),rgba(168,85,247,0.1));
            border-radius:10px; margin:0 auto 12px;
            display:flex; align-items:center; justify-content:center; font-size:40px;
        }
        .compare-book-title { font-size:15px; font-weight:800; margin-bottom:4px; }
        .compare-book-author { font-size:12px; color:rgba(255,255,255,0.4); margin-bottom:10px; }

        /* Data rows */
        .compare-table td {
            padding:14px 16px;
            border-right:1px solid rgba(255,255,255,0.06);
            border-bottom:1px solid rgba(255,255,255,0.04);
            font-size:14px; text-align:center; vertical-align:middle;
        }
        .compare-table td:last-child { border-right:none; }
        .compare-table td.label-cell { text-align:left; }
        .compare-table tr:hover td { background:rgba(255,255,255,0.02); }

        /* Best value highlight */
        .best { color:#6ee7b7; font-weight:700; position:relative; }
        .best::after { content:'✓ Best'; font-size:10px; display:block; color:#6ee7b7; opacity:0.7; }

        /* Price cell */
        .price-cell { font-size:20px; font-weight:800; background:linear-gradient(135deg,#a78bfa,#f472b6); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }

        /* Rating stars */
        .stars-cell { color:#fbbf24; font-size:14px; }

        /* Condition badge */
        .cond-badge { display:inline-block; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:700; }
        .cond-new { background:rgba(52,211,153,0.15); color:#6ee7b7; }
        .cond-like { background:rgba(96,165,250,0.15); color:#93c5fd; }
        .cond-good { background:rgba(251,191,36,0.15); color:#fcd34d; }
        .cond-fair { background:rgba(251,146,60,0.15); color:#fdba74; }
        .cond-poor { background:rgba(239,68,68,0.15); color:#fca5a5; }

        /* Status */
        .status-available { color:#6ee7b7; font-weight:700; }
        .status-sold { color:#f87171; font-weight:700; }

        /* Action row */
        .action-cell { padding:20px 16px !important; }
        .btn-buy-compare {
            display:block; width:100%; padding:12px;
            background:linear-gradient(135deg,#7c3aed,#a855f7);
            color:#fff; border:none; border-radius:10px; font-size:13px; font-weight:700;
            cursor:pointer; font-family:'Inter',sans-serif; text-decoration:none;
            text-align:center; transition:all 0.2s; margin-bottom:8px;
        }
        .btn-buy-compare:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(124,58,237,0.4); }
        .btn-remove-compare {
            display:block; width:100%; padding:8px;
            background:rgba(239,68,68,0.1); color:#f87171;
            border:1px solid rgba(239,68,68,0.2); border-radius:8px;
            font-size:12px; font-weight:600; cursor:pointer;
            font-family:'Inter',sans-serif; transition:all 0.2s;
        }
        .btn-remove-compare:hover { background:rgba(239,68,68,0.2); }

        /* Back btn */
        .btn-back {
            display:inline-flex; align-items:center; gap:8px;
            padding:10px 20px; background:rgba(255,255,255,0.06);
            border:1px solid rgba(255,255,255,0.1); border-radius:10px;
            color:rgba(255,255,255,0.7); font-size:13px; font-weight:600;
            text-decoration:none; transition:all 0.2s; margin-bottom:24px;
        }
        .btn-back:hover { background:rgba(255,255,255,0.1); color:#fff; }

        /* NA */
        .na { color:rgba(255,255,255,0.2); font-size:13px; }

        /* Section header row */
        .section-row td { background:rgba(124,58,237,0.06); font-size:11px; font-weight:700; color:#a78bfa; text-transform:uppercase; letter-spacing:1px; padding:8px 16px !important; }
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
        <a href="{{ route('books.index') }}" class="nav-link">📚 Browse Books</a>
        @auth
            @if(auth()->user()->isBuyer())
                <a href="{{ route('buyer.dashboard') }}" class="nav-link">Dashboard</a>
            @endif
        @endauth
    </div>
</nav>

<div class="page">

    <a href="{{ route('books.index') }}" class="btn-back">← Back to Books</a>

    <div class="page-header">
        <h1>⚖️ Compare Books</h1>
        <p>{{ $books->count() }}টি book side-by-side compare করছেন</p>
    </div>

    @php
        $minPrice = $books->min('price');
        $maxRating = $books->max(fn($b) => $b->averageRating());
        $maxPages = $books->max('pages');
    @endphp

    <div class="compare-wrap">
        <table class="compare-table">

            {{-- Book Headers --}}
            <thead>
                <tr class="book-header">
                    <th class="label-cell label-col"></th>
                    @foreach($books as $book)
                        <th class="book-header-cell book-col">
                            @if($book->image)
                                <img src="{{ Storage::url($book->image) }}" alt="{{ $book->title }}" class="book-cover-compare">
                            @else
                                <div class="book-cover-placeholder-compare">📚</div>
                            @endif
                            <div class="compare-book-title">{{ $book->title }}</div>
                            <div class="compare-book-author">by {{ $book->author }}</div>
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                {{-- Section: Pricing --}}
                <tr class="section-row">
                    <td colspan="{{ $books->count() + 1 }}">💰 Pricing</td>
                </tr>
                <tr>
                    <td class="label-cell">Price</td>
                    @foreach($books as $book)
                        <td class="price-cell {{ $book->price == $minPrice ? 'best' : '' }}">
                            ৳{{ number_format($book->price, 0) }}
                        </td>
                    @endforeach
                </tr>

                {{-- Section: Details --}}
                <tr class="section-row">
                    <td colspan="{{ $books->count() + 1 }}">📋 Details</td>
                </tr>
                <tr>
                    <td class="label-cell">Condition</td>
                    @foreach($books as $book)
                        <td>
                            @php $cc = match($book->condition) { 'New'=>'cond-new','Like New'=>'cond-like','Good'=>'cond-good','Fair'=>'cond-fair',default=>'cond-poor' }; @endphp
                            <span class="cond-badge {{ $cc }}">{{ $book->condition }}</span>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="label-cell">Category</td>
                    @foreach($books as $book)
                        <td>{{ $book->category?->name ?? '<span class="na">N/A</span>' }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="label-cell">Language</td>
                    @foreach($books as $book)
                        <td>{{ $book->language ?? '<span class="na">N/A</span>' }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="label-cell">Pages</td>
                    @foreach($books as $book)
                        <td class="{{ $book->pages && $book->pages == $maxPages ? 'best' : '' }}">
                            {{ $book->pages ? $book->pages . ' pages' : '<span class="na">N/A</span>' }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="label-cell">Publisher</td>
                    @foreach($books as $book)
                        <td>{{ $book->publisher ?? '<span class="na">N/A</span>' }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="label-cell">Published</td>
                    @foreach($books as $book)
                        <td>{{ $book->published_year ?? '<span class="na">N/A</span>' }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="label-cell">ISBN</td>
                    @foreach($books as $book)
                        <td style="font-size:12px;">{{ $book->isbn ?? '<span class="na">N/A</span>' }}</td>
                    @endforeach
                </tr>

                {{-- Section: Ratings --}}
                <tr class="section-row">
                    <td colspan="{{ $books->count() + 1 }}">⭐ Ratings & Reviews</td>
                </tr>
                <tr>
                    <td class="label-cell">Rating</td>
                    @foreach($books as $book)
                        @php $r = $book->averageRating(); @endphp
                        <td class="{{ $r == $maxRating && $r > 0 ? 'best' : '' }}">
                            <div class="stars-cell">
                                @for($i=1;$i<=5;$i++){{ $i <= $r ? '⭐' : '☆' }}@endfor
                            </div>
                            <div style="font-size:12px; color:rgba(255,255,255,0.4); margin-top:3px;">{{ $r }} / 5</div>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="label-cell">Reviews</td>
                    @foreach($books as $book)
                        <td>{{ $book->reviews->count() }} reviews</td>
                    @endforeach
                </tr>

                {{-- Section: Availability --}}
                <tr class="section-row">
                    <td colspan="{{ $books->count() + 1 }}">📦 Availability</td>
                </tr>
                <tr>
                    <td class="label-cell">Status</td>
                    @foreach($books as $book)
                        <td class="status-{{ $book->status }}">
                            {{ $book->status === 'available' ? '✅ Available' : '❌ Sold' }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="label-cell">Seller</td>
                    @foreach($books as $book)
                        <td style="font-size:13px;">{{ $book->user->name }}</td>
                    @endforeach
                </tr>

                {{-- Actions --}}
                <tr>
                    <td class="label-cell"></td>
                    @foreach($books as $book)
                        <td class="action-cell">
                            @auth
                                @if(auth()->user()->isBuyer() && $book->status === 'available')
                                    <form method="POST" action="{{ route('cart.add', $book) }}">
                                        @csrf
                                        <button type="submit" class="btn-buy-compare">🛒 Add to Cart</button>
                                    </form>
                                @elseif(!auth()->check())
                                    <a href="{{ route('login') }}" class="btn-buy-compare">🔐 Login to Buy</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn-buy-compare">🔐 Login to Buy</a>
                            @endauth
                            <form method="POST" action="{{ route('books.compare.remove', $book) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-remove-compare">✕ Remove</button>
                            </form>
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>