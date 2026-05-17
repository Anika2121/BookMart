<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
    <title>Manage Books - BookMart Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#09090f; color:#fff; min-height:100vh; }
        ::-webkit-scrollbar { width:5px; }
        ::-webkit-scrollbar-thumb { background:rgba(99,102,241,0.4); border-radius:4px; }
        .layout { display:flex; min-height:100vh; }
        .sidebar { width:240px; flex-shrink:0; background:#0c0c18; border-right:0.5px solid rgba(255,255,255,0.06); display:flex; flex-direction:column; position:fixed; top:0; left:0; height:100vh; z-index:50; }
        .sb-brand { padding:24px 20px; border-bottom:0.5px solid rgba(255,255,255,0.06); }
        .sb-brand-top { display:flex; align-items:center; gap:10px; margin-bottom:6px; }
        .sb-brand-icon { width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,#6366f1,#a855f7); display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0; }
        .sb-brand-name { font-size:16px; font-weight:800; color:#fff; }
        .sb-brand-name span { background:linear-gradient(135deg,#818cf8,#c084fc); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .sb-brand-sub { font-size:11px; color:rgba(255,255,255,0.25); padding-left:46px; }
        .sb-admin-info { padding:16px 20px; border-bottom:0.5px solid rgba(255,255,255,0.06); display:flex; align-items:center; gap:10px; }
        .sb-admin-av { width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,#6366f1,#a855f7); display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; flex-shrink:0; }
        .sb-admin-name { font-size:13px; font-weight:600; color:#fff; }
        .sb-admin-role { font-size:11px; color:rgba(255,255,255,0.3); display:flex; align-items:center; gap:4px; margin-top:2px; }
        .sb-admin-dot { width:5px; height:5px; border-radius:50%; background:#f59e0b; }
        .sb-nav { flex:1; padding:12px 10px; overflow-y:auto; }
        .sb-label { font-size:10px; font-weight:700; color:rgba(255,255,255,0.22); text-transform:uppercase; letter-spacing:1px; padding:8px 10px 4px; }
        .sb-link { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; text-decoration:none; color:rgba(255,255,255,0.5); font-size:13px; font-weight:500; transition:all 0.2s; margin-bottom:2px; border:1px solid transparent; }
        .sb-link:hover { background:rgba(255,255,255,0.05); color:#fff; }
        .sb-link.active { background:rgba(99,102,241,0.15); color:#818cf8; border-color:rgba(99,102,241,0.2); }
        .sb-link-icon { font-size:15px; width:20px; text-align:center; }
        .sb-bottom { padding:16px; border-top:0.5px solid rgba(255,255,255,0.06); }
        .sb-logout { width:100%; padding:10px; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); border-radius:10px; color:#f87171; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .sb-logout:hover { background:rgba(239,68,68,0.2); }

        .main { margin-left:240px; flex:1; padding:28px 32px; }
        .topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; }
        .topbar h1 { font-size:22px; font-weight:700; color:#fff; letter-spacing:-0.4px; }
        .topbar p { font-size:13px; color:rgba(255,255,255,0.35); margin-top:3px; }

        .alert { padding:12px 18px; border-radius:12px; margin-bottom:20px; font-size:13px; display:flex; align-items:center; gap:8px; }
        .alert-success { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#6ee7b7; }

        .stats-row { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:20px; }
        .stat { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:13px; padding:16px 18px; display:flex; align-items:center; gap:12px; }
        .stat-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
        .stat-val { font-size:22px; font-weight:800; }
        .stat-label { font-size:11px; color:rgba(255,255,255,0.35); margin-top:2px; }

        .filter-bar { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:13px; padding:14px 18px; margin-bottom:18px; display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
        .search-input { flex:1; min-width:200px; padding:9px 14px; background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.1); border-radius:9px; color:#fff; font-size:13px; outline:none; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .search-input:focus { border-color:rgba(99,102,241,0.5); background:rgba(99,102,241,0.05); }
        .search-input::placeholder { color:rgba(255,255,255,0.2); }
        .filter-select { padding:9px 14px; background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.1); border-radius:9px; color:#fff; font-size:13px; outline:none; font-family:'Inter',sans-serif; cursor:pointer; }
        .filter-select option { background:#0f0f1e; }
        .btn-search { padding:9px 20px; background:linear-gradient(135deg,#6366f1,#818cf8); border:none; border-radius:9px; color:#fff; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .btn-search:hover { transform:translateY(-1px); box-shadow:0 4px 14px rgba(99,102,241,0.4); }
        .btn-reset { padding:9px 16px; background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.1); border-radius:9px; color:rgba(255,255,255,0.5); font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .btn-reset:hover { color:#fff; background:rgba(255,255,255,0.08); }

        .table-card { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:16px; overflow:hidden; }
        .table-header { padding:16px 22px; border-bottom:0.5px solid rgba(255,255,255,0.06); display:flex; justify-content:space-between; align-items:center; }
        .table-title { font-size:14px; font-weight:700; color:#fff; }
        .table-count { font-size:12px; color:rgba(255,255,255,0.3); background:rgba(255,255,255,0.05); padding:3px 10px; border-radius:20px; }

        table { width:100%; border-collapse:collapse; }
        th { padding:11px 18px; text-align:left; font-size:11px; font-weight:600; color:rgba(255,255,255,0.3); text-transform:uppercase; letter-spacing:0.7px; background:rgba(255,255,255,0.02); }
        td { padding:13px 18px; border-top:0.5px solid rgba(255,255,255,0.05); font-size:13px; vertical-align:middle; }
        tbody tr:hover td { background:rgba(255,255,255,0.02); }

        .book-cell { display:flex; align-items:center; gap:10px; }
        .book-thumb { width:40px; height:52px; border-radius:7px; object-fit:cover; flex-shrink:0; border:0.5px solid rgba(255,255,255,0.1); }
        .book-placeholder { width:40px; height:52px; border-radius:7px; background:rgba(99,102,241,0.15); display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
        .book-name { font-size:13px; font-weight:600; color:#fff; max-width:160px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .book-author { font-size:11px; color:rgba(255,255,255,0.35); margin-top:2px; }

        .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600; }
        .badge-available { background:rgba(52,211,153,0.12); color:#34d399; border:0.5px solid rgba(52,211,153,0.25); }
        .badge-sold { background:rgba(239,68,68,0.12); color:#f87171; border:0.5px solid rgba(239,68,68,0.25); }
        .badge-pending { background:rgba(251,191,36,0.12); color:#fbbf24; border:0.5px solid rgba(251,191,36,0.25); }
        .badge-New { background:rgba(167,139,250,0.12); color:#c4b5fd; border:0.5px solid rgba(167,139,250,0.25); }
        .badge-Like { background:rgba(96,165,250,0.12); color:#93c5fd; border:0.5px solid rgba(96,165,250,0.25); }
        .badge-Good { background:rgba(52,211,153,0.12); color:#6ee7b7; border:0.5px solid rgba(52,211,153,0.25); }
        .badge-Fair { background:rgba(251,191,36,0.12); color:#fcd34d; border:0.5px solid rgba(251,191,36,0.25); }
        .badge-Poor { background:rgba(239,68,68,0.12); color:#fca5a5; border:0.5px solid rgba(239,68,68,0.25); }

        .stars { color:#fbbf24; font-size:12px; }
        .price-text { font-weight:700; color:#c084fc; }

        .tbl-btn { padding:5px 11px; border-radius:7px; font-size:11px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; border:0.5px solid transparent; display:inline-flex; align-items:center; gap:3px; }
        .btn-approve { background:rgba(52,211,153,0.1); color:#34d399; border-color:rgba(52,211,153,0.25); }
        .btn-approve:hover { background:rgba(52,211,153,0.2); }
        .btn-reject { background:rgba(251,191,36,0.1); color:#fbbf24; border-color:rgba(251,191,36,0.25); }
        .btn-reject:hover { background:rgba(251,191,36,0.2); }
        .btn-view { background:rgba(99,102,241,0.1); color:#818cf8; border-color:rgba(99,102,241,0.25); }
        .btn-view:hover { background:rgba(99,102,241,0.2); }
        .btn-del { background:rgba(239,68,68,0.1); color:#f87171; border-color:rgba(239,68,68,0.25); }
        .btn-del:hover { background:rgba(239,68,68,0.2); }

        .action-group { display:flex; gap:5px; flex-wrap:wrap; }

        .empty { padding:48px; text-align:center; color:rgba(255,255,255,0.25); }
        .empty-icon { font-size:36px; margin-bottom:10px; }

        .pagination-wrap { padding:14px 20px; border-top:0.5px solid rgba(255,255,255,0.05); }

        @media(max-width:768px) { .sidebar { display:none; } .main { margin-left:0; padding:20px 16px; } .stats-row { grid-template-columns:repeat(2,1fr); } }
    </style>
</head>
<body>
<div class="layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sb-brand">
      <div class="sb-brand-top">
        <div class="sb-brand-icon">📚</div>
        <div class="sb-brand-name">Book<span>Mart</span></div>
      </div>
      <div class="sb-brand-sub">Admin Control Panel</div>
    </div>
    <div class="sb-admin-info">
      <div class="sb-admin-av">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
      <div>
        <div class="sb-admin-name">{{ auth()->user()->name }}</div>
        <div class="sb-admin-role"><span class="sb-admin-dot"></span> Super Admin</div>
      </div>
    </div>
    <nav class="sb-nav">
      <div class="sb-label">Overview</div>
      <a href="{{ route('admin.dashboard') }}" class="sb-link">
        <span class="sb-link-icon">⚡</span> Dashboard
      </a>
      <div class="sb-label" style="margin-top:8px;">Management</div>
      <a href="{{ route('admin.users') }}" class="sb-link">
        <span class="sb-link-icon">👥</span> Users
      </a>
      <a href="{{ route('admin.books') }}" class="sb-link active">
        <span class="sb-link-icon">📖</span> Books
      </a>
      <a href="{{ route('admin.orders') }}" class="sb-link">
        <span class="sb-link-icon">🛒</span> Orders
      </a>
      <a href="{{ route('admin.categories') }}" class="sb-link">
        <span class="sb-link-icon">🏷️</span> Categories
      </a>
      <div class="sb-label" style="margin-top:8px;">Site</div>
      <a href="{{ route('home') }}" class="sb-link">
        <span class="sb-link-icon">🌐</span> View Site
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
        <h1>📖 Manage Books</h1>
        <p>View, search and manage all book listings</p>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <!-- STATS -->
    <div class="stats-row">
      <div class="stat">
        <div class="stat-icon" style="background:rgba(99,102,241,0.15);">📚</div>
        <div>
          <div class="stat-val" style="color:#818cf8;">{{ $books->total() }}</div>
          <div class="stat-label">Total Books</div>
        </div>
      </div>
      <div class="stat">
        <div class="stat-icon" style="background:rgba(52,211,153,0.15);">✅</div>
        <div>
          <div class="stat-val" style="color:#34d399;">{{ $books->getCollection()->where('status','available')->count() }}</div>
          <div class="stat-label">Available</div>
        </div>
      </div>
      <div class="stat">
        <div class="stat-icon" style="background:rgba(239,68,68,0.15);">🔴</div>
        <div>
          <div class="stat-val" style="color:#f87171;">{{ $books->getCollection()->where('status','sold')->count() }}</div>
          <div class="stat-label">Sold</div>
        </div>
      </div>
      <div class="stat">
        <div class="stat-icon" style="background:rgba(251,191,36,0.15);">⏳</div>
        <div>
          <div class="stat-val" style="color:#fbbf24;">{{ $books->getCollection()->where('status','pending')->count() }}</div>
          <div class="stat-label">Pending</div>
        </div>
      </div>
    </div>

    <!-- FILTER -->
    <form method="GET" action="{{ route('admin.books') }}" class="filter-bar">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Search by title, author or seller..." class="search-input">
      <select name="status" class="filter-select">
        <option value="">All Status</option>
        <option value="available" {{ request('status')==='available' ? 'selected':'' }}>✅ Available</option>
        <option value="sold" {{ request('status')==='sold' ? 'selected':'' }}>🔴 Sold</option>
        <option value="pending" {{ request('status')==='pending' ? 'selected':'' }}>⏳ Pending</option>
      </select>
      <select name="condition" class="filter-select">
        <option value="">All Conditions</option>
        <option value="New" {{ request('condition')==='New' ? 'selected':'' }}>🆕 New</option>
        <option value="Like New" {{ request('condition')==='Like New' ? 'selected':'' }}>👍 Like New</option>
        <option value="Good" {{ request('condition')==='Good' ? 'selected':'' }}>✔️ Good</option>
        <option value="Fair" {{ request('condition')==='Fair' ? 'selected':'' }}>👌 Fair</option>
        <option value="Poor" {{ request('condition')==='Poor' ? 'selected':'' }}>👎 Poor</option>
      </select>
      <button type="submit" class="btn-search">🔍 Search</button>
      <a href="{{ route('admin.books') }}" class="btn-reset">Reset</a>
    </form>

    <!-- TABLE -->
    <div class="table-card">
      <div class="table-header">
        <span class="table-title">All Book Listings</span>
        <span class="table-count">{{ $books->total() }} books</span>
      </div>

      @if($books->isEmpty())
        <div class="empty">
          <div class="empty-icon">📚</div>
          <p>No books found</p>
        </div>
      @else
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Book</th>
              <th>Seller</th>
              <th>Price</th>
              <th>Condition</th>
              <th>Rating</th>
              <th>Status</th>
              <th>Listed</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($books as $index => $book)
              <tr>
                <td style="color:rgba(255,255,255,0.25);font-size:12px;">{{ $books->firstItem() + $index }}</td>
                <td>
                  <div class="book-cell">
                    @if($book->image)
                      <img src="{{ Storage::url($book->image) }}" class="book-thumb" alt="{{ $book->title }}">
                    @else
                      <div class="book-placeholder">📚</div>
                    @endif
                    <div>
                      <div class="book-name">{{ Str::limit($book->title,22) }}</div>
                      <div class="book-author">{{ $book->author }}</div>
                    </div>
                  </div>
                </td>
                <td>
                  <div style="font-size:13px;font-weight:600;color:#c4b5fd;">{{ $book->user->name ?? 'N/A' }}</div>
                  <div style="font-size:11px;color:rgba(255,255,255,0.3);">{{ $book->user->email ?? '' }}</div>
                </td>
                <td><span class="price-text">৳{{ number_format($book->price,0) }}</span></td>
                <td>
                  @php $condKey = explode(' ',$book->condition)[0]; @endphp
                  <span class="badge badge-{{ $condKey }}">{{ $book->condition }}</span>
                </td>
                <td>
                  @php $avg = round($book->reviews->avg('rating') ?? 0,1); @endphp
                  <div class="stars">
                    @for($i=1;$i<=5;$i++){{ $i<=round($avg)?'★':'☆' }}@endfor
                  </div>
                  <div style="font-size:11px;color:rgba(255,255,255,0.3);margin-top:2px;">{{ $avg }} ({{ $book->reviews->count() }})</div>
                </td>
                <td><span class="badge badge-{{ $book->status }}">{{ ucfirst($book->status) }}</span></td>
                <td style="color:rgba(255,255,255,0.4);font-size:12px;">{{ $book->created_at->format('d M Y') }}</td>
                <td>
                  <div class="action-group">
                    <a href="{{ route('books.show',$book) }}" class="tbl-btn btn-view">👁️ View</a>
                    @if($book->status === 'available')
                      <form method="POST" action="{{ route('admin.books.reject',$book) }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="tbl-btn btn-reject">🔴 Mark Sold</button>
                      </form>
                    @elseif($book->status === 'sold' || $book->status === 'pending')
                      <form method="POST" action="{{ route('admin.books.approve',$book) }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="tbl-btn btn-approve">✅ Activate</button>
                      </form>
                    @endif
                    <form method="POST" action="{{ route('books.destroy',$book) }}" style="margin:0;" onsubmit="return confirm('Delete {{ addslashes($book->title) }}?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="tbl-btn btn-del">🗑️ Delete</button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div class="pagination-wrap">{{ $books->links() }}</div>
      @endif
    </div>
  </main>
</div>
</body>
</html>