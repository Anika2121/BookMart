<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
    <title>Manage Orders - BookMart Admin</title>
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

        .stats-row { display:grid; grid-template-columns:repeat(5,1fr); gap:14px; margin-bottom:20px; }
        .stat { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:13px; padding:16px 18px; text-align:center; position:relative; overflow:hidden; }
        .stat::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; border-radius:13px 13px 0 0; }
        .stat.s1::before { background:linear-gradient(90deg,#6366f1,#818cf8); }
        .stat.s2::before { background:linear-gradient(90deg,#f59e0b,#fbbf24); }
        .stat.s3::before { background:linear-gradient(90deg,#0ea5e9,#60a5fa); }
        .stat.s4::before { background:linear-gradient(90deg,#a855f7,#c084fc); }
        .stat.s5::before { background:linear-gradient(90deg,#10b981,#34d399); }
        .stat-val { font-size:24px; font-weight:800; color:#fff; margin-bottom:4px; }
        .stat-label { font-size:11px; color:rgba(255,255,255,0.35); }

        .filter-bar { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:13px; padding:14px 18px; margin-bottom:18px; display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
        .search-input { flex:1; min-width:200px; padding:9px 14px; background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.1); border-radius:9px; color:#fff; font-size:13px; outline:none; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .search-input:focus { border-color:rgba(99,102,241,0.5); background:rgba(99,102,241,0.05); }
        .search-input::placeholder { color:rgba(255,255,255,0.2); }
        .filter-select { padding:9px 14px; background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.1); border-radius:9px; color:#fff; font-size:13px; outline:none; font-family:'Inter',sans-serif; cursor:pointer; }
        .filter-select option { background:#0f0f1e; }

        .table-card { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:16px; overflow:hidden; }
        .table-header { padding:16px 22px; border-bottom:0.5px solid rgba(255,255,255,0.06); display:flex; justify-content:space-between; align-items:center; }
        .table-title { font-size:14px; font-weight:700; color:#fff; }
        .table-count { font-size:12px; color:rgba(255,255,255,0.3); background:rgba(255,255,255,0.05); padding:3px 10px; border-radius:20px; }

        table { width:100%; border-collapse:collapse; }
        th { padding:11px 18px; text-align:left; font-size:11px; font-weight:600; color:rgba(255,255,255,0.3); text-transform:uppercase; letter-spacing:0.7px; background:rgba(255,255,255,0.02); }
        td { padding:13px 18px; border-top:0.5px solid rgba(255,255,255,0.05); font-size:13px; vertical-align:middle; }
        tbody tr:hover td { background:rgba(255,255,255,0.02); }

        .book-title { font-weight:600; color:#fff; font-size:13px; }
        .book-author { font-size:11px; color:rgba(255,255,255,0.35); margin-top:2px; }
        .user-name { font-weight:500; color:#fff; font-size:13px; }
        .user-email { font-size:11px; color:rgba(255,255,255,0.35); margin-top:2px; }
        .price-text { font-weight:700; color:#34d399; font-size:14px; }
        .order-id { font-family:monospace; font-size:12px; color:rgba(255,255,255,0.4); background:rgba(255,255,255,0.04); padding:3px 8px; border-radius:5px; }

        .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600; }
        .badge-pending { background:rgba(251,191,36,0.12); color:#fbbf24; border:0.5px solid rgba(251,191,36,0.25); }
        .badge-confirmed { background:rgba(96,165,250,0.12); color:#60a5fa; border:0.5px solid rgba(96,165,250,0.25); }
        .badge-shipped { background:rgba(167,139,250,0.12); color:#a78bfa; border:0.5px solid rgba(167,139,250,0.25); }
        .badge-delivered { background:rgba(52,211,153,0.12); color:#34d399; border:0.5px solid rgba(52,211,153,0.25); }
        .badge-cancelled { background:rgba(239,68,68,0.12); color:#f87171; border:0.5px solid rgba(239,68,68,0.25); }

        .status-select { padding:7px 10px; background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; font-size:12px; font-weight:500; outline:none; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.15s; }
        .status-select:hover { border-color:rgba(99,102,241,0.4); }
        .status-select option { background:#0f0f1e; }
        .btn-update { padding:7px 14px; background:linear-gradient(135deg,#6366f1,#818cf8); border:none; border-radius:8px; color:#fff; font-size:12px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; white-space:nowrap; }
        .btn-update:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(99,102,241,0.4); }

        .empty { padding:48px; text-align:center; color:rgba(255,255,255,0.25); }
        .empty-icon { font-size:36px; margin-bottom:10px; }

        .pagination-wrap { padding:14px 20px; border-top:0.5px solid rgba(255,255,255,0.05); }

        @media(max-width:768px) { .sidebar { display:none; } .main { margin-left:0; padding:20px 16px; } .stats-row { grid-template-columns:repeat(3,1fr); } }
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
      <a href="{{ route('admin.books') }}" class="sb-link">
        <span class="sb-link-icon">📖</span> Books
      </a>
      <a href="{{ route('admin.orders') }}" class="sb-link active">
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
        <h1>🛒 Manage Orders</h1>
        <p>View and update all orders across the platform</p>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <!-- STATS -->
    @php
      $allOrders = $orders->getCollection();
    @endphp
    <div class="stats-row">
      <div class="stat s1">
        <div class="stat-val">{{ $orders->total() }}</div>
        <div class="stat-label">Total Orders</div>
      </div>
      <div class="stat s2">
        <div class="stat-val" style="color:#fbbf24;">{{ $allOrders->where('status','pending')->count() }}</div>
        <div class="stat-label">Pending</div>
      </div>
      <div class="stat s3">
        <div class="stat-val" style="color:#60a5fa;">{{ $allOrders->where('status','confirmed')->count() }}</div>
        <div class="stat-label">Confirmed</div>
      </div>
      <div class="stat s4">
        <div class="stat-val" style="color:#c084fc;">{{ $allOrders->where('status','shipped')->count() }}</div>
        <div class="stat-label">Shipped</div>
      </div>
      <div class="stat s5">
        <div class="stat-val" style="color:#34d399;">{{ $allOrders->where('status','delivered')->count() }}</div>
        <div class="stat-label">Delivered</div>
      </div>
    </div>

    <!-- FILTER -->
    <div class="filter-bar">
      <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search by book, buyer or seller...">
      <select class="filter-select" id="statusFilter">
        <option value="">All Status</option>
        <option value="pending">⏳ Pending</option>
        <option value="confirmed">✅ Confirmed</option>
        <option value="shipped">🚚 Shipped</option>
        <option value="delivered">📦 Delivered</option>
        <option value="cancelled">❌ Cancelled</option>
      </select>
    </div>

    <!-- TABLE -->
    <div class="table-card">
      <div class="table-header">
        <span class="table-title">All Orders</span>
        <span class="table-count">{{ $orders->total() }} orders</span>
      </div>

      @if($orders->isEmpty())
        <div class="empty">
          <div class="empty-icon">📦</div>
          <p>No orders yet</p>
        </div>
      @else
        <table>
          <thead>
            <tr>
              <th>Order</th>
              <th>Book</th>
              <th>Buyer</th>
              <th>Seller</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Date</th>
              <th>Update</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
              <tr class="order-row" data-status="{{ $order->status }}">
                <td><span class="order-id">#{{ $order->id }}</span></td>
                <td>
                  <div class="book-title">{{ Str::limit($order->book->title ?? 'N/A', 25) }}</div>
                  <div class="book-author">{{ $order->book->author ?? '' }}</div>
                </td>
                <td>
                  <div class="user-name">{{ $order->buyer->name ?? 'N/A' }}</div>
                  <div class="user-email">{{ $order->buyer->email ?? '' }}</div>
                </td>
                <td>
                  <div class="user-name">{{ $order->book->user->name ?? 'N/A' }}</div>
                  <div class="user-email">{{ $order->book->user->email ?? '' }}</div>
                </td>
                <td><span class="price-text">৳{{ number_format($order->price,0) }}</span></td>
                <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                <td style="color:rgba(255,255,255,0.4);font-size:12px;">{{ $order->created_at->format('d M Y') }}</td>
                <td>
                  <form method="POST" action="{{ route('admin.orders.status',$order) }}" style="display:flex;gap:6px;align-items:center;">
                    @csrf @method('PATCH')
                    <select name="status" class="status-select">
                      <option value="pending" {{ $order->status=='pending' ? 'selected':'' }}>⏳ Pending</option>
                      <option value="confirmed" {{ $order->status=='confirmed' ? 'selected':'' }}>✅ Confirmed</option>
                      <option value="shipped" {{ $order->status=='shipped' ? 'selected':'' }}>🚚 Shipped</option>
                      <option value="delivered" {{ $order->status=='delivered' ? 'selected':'' }}>📦 Delivered</option>
                      <option value="cancelled" {{ $order->status=='cancelled' ? 'selected':'' }}>❌ Cancelled</option>
                    </select>
                    <button type="submit" class="btn-update">Update</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div class="pagination-wrap">{{ $orders->links() }}</div>
      @endif
    </div>
  </main>
</div>

<script>
document.getElementById('searchInput').addEventListener('input', filterRows);
document.getElementById('statusFilter').addEventListener('change', filterRows);

function filterRows() {
  const search = document.getElementById('searchInput').value.toLowerCase();
  const status = document.getElementById('statusFilter').value;
  document.querySelectorAll('.order-row').forEach(row => {
    const text = row.textContent.toLowerCase();
    const ok = text.includes(search) && (!status || row.dataset.status === status);
    row.style.display = ok ? '' : 'none';
  });
}
</script>
</body>
</html>