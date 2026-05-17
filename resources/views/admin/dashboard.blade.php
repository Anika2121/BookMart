<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
    <title>Admin Dashboard - BookMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#09090f; color:#fff; min-height:100vh; }
        ::-webkit-scrollbar { width:5px; }
        ::-webkit-scrollbar-thumb { background:rgba(99,102,241,0.4); border-radius:4px; }

        .layout { display:flex; min-height:100vh; }

        /* SIDEBAR */
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
        .sb-link-badge { margin-left:auto; font-size:10px; padding:2px 7px; border-radius:10px; background:rgba(239,68,68,0.2); color:#f87171; font-weight:700; }
        .sb-bottom { padding:16px; border-top:0.5px solid rgba(255,255,255,0.06); }
        .sb-logout { width:100%; padding:10px; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); border-radius:10px; color:#f87171; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .sb-logout:hover { background:rgba(239,68,68,0.2); }

        /* MAIN */
        .main { margin-left:240px; flex:1; padding:28px 32px; }

        .topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; }
        .topbar-left h1 { font-size:22px; font-weight:700; color:#fff; letter-spacing:-0.4px; }
        .topbar-left p { font-size:13px; color:rgba(255,255,255,0.35); margin-top:3px; }
        .topbar-right { display:flex; gap:10px; }
        .btn-site { display:flex; align-items:center; gap:7px; padding:9px 18px; background:rgba(99,102,241,0.15); border:0.5px solid rgba(99,102,241,0.3); color:#818cf8; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; transition:all 0.2s; }
        .btn-site:hover { background:rgba(99,102,241,0.25); }

        /* ALERT */
        .alert { padding:12px 18px; border-radius:12px; margin-bottom:24px; font-size:13px; display:flex; align-items:center; gap:8px; }
        .alert-success { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#6ee7b7; }

        /* STATS */
        .stats-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:14px; margin-bottom:24px; }
        @media(max-width:1200px) { .stats-grid { grid-template-columns:repeat(3,1fr); } }
        .stat-card { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:14px; padding:18px; position:relative; overflow:hidden; transition:all 0.2s; }
        .stat-card::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; border-radius:14px 14px 0 0; }
        .stat-card.indigo::before { background:linear-gradient(90deg,#6366f1,#818cf8); }
        .stat-card.purple::before { background:linear-gradient(90deg,#a855f7,#c084fc); }
        .stat-card.green::before { background:linear-gradient(90deg,#059669,#34d399); }
        .stat-card.orange::before { background:linear-gradient(90deg,#d97706,#fbbf24); }
        .stat-card.pink::before { background:linear-gradient(90deg,#db2777,#f472b6); }
        .stat-card:hover { border-color:rgba(255,255,255,0.14); transform:translateY(-2px); }
        .stat-top { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px; }
        .stat-icon { width:40px; height:40px; border-radius:11px; display:flex; align-items:center; justify-content:center; font-size:17px; }
        .stat-icon.indigo { background:rgba(99,102,241,0.15); }
        .stat-icon.purple { background:rgba(168,85,247,0.15); }
        .stat-icon.green { background:rgba(5,150,105,0.15); }
        .stat-icon.orange { background:rgba(217,119,6,0.15); }
        .stat-icon.pink { background:rgba(219,39,119,0.15); }
        .stat-val { font-size:26px; font-weight:800; color:#fff; margin-bottom:4px; }
        .stat-label { font-size:11px; color:rgba(255,255,255,0.35); font-weight:500; }

        /* QUICK ACTIONS */
        .actions-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:12px; margin-bottom:24px; }
        .action-btn { display:flex; flex-direction:column; align-items:center; gap:8px; padding:16px 10px; background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:13px; text-decoration:none; transition:all 0.2s; }
        .action-btn:hover { border-color:rgba(99,102,241,0.35); background:rgba(99,102,241,0.07); transform:translateY(-2px); }
        .action-btn-icon { font-size:22px; }
        .action-btn-label { font-size:12px; font-weight:600; color:rgba(255,255,255,0.6); text-align:center; }

        /* TWO COL */
        .two-col { display:grid; grid-template-columns:2fr 1fr; gap:20px; margin-bottom:24px; }
        @media(max-width:1100px) { .two-col { grid-template-columns:1fr; } }

        /* CARD */
        .card { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:16px; overflow:hidden; }
        .card-header { padding:16px 22px; border-bottom:0.5px solid rgba(255,255,255,0.06); display:flex; justify-content:space-between; align-items:center; }
        .card-title { font-size:14px; font-weight:700; color:#fff; }
        .card-link { font-size:12px; color:#818cf8; text-decoration:none; font-weight:600; }
        .card-link:hover { color:#a5b4fc; }

        /* TABLE */
        table { width:100%; border-collapse:collapse; }
        th { padding:11px 18px; text-align:left; font-size:11px; font-weight:600; color:rgba(255,255,255,0.3); text-transform:uppercase; letter-spacing:0.7px; background:rgba(255,255,255,0.02); }
        td { padding:13px 18px; border-top:0.5px solid rgba(255,255,255,0.05); font-size:13px; }
        tr:hover td { background:rgba(255,255,255,0.02); }

        /* BADGES */
        .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600; }
        .badge-pending { background:rgba(251,191,36,0.12); color:#fbbf24; }
        .badge-confirmed { background:rgba(96,165,250,0.12); color:#60a5fa; }
        .badge-shipped { background:rgba(167,139,250,0.12); color:#a78bfa; }
        .badge-delivered { background:rgba(52,211,153,0.12); color:#34d399; }
        .badge-cancelled { background:rgba(239,68,68,0.12); color:#f87171; }
        .badge-buyer { background:rgba(52,211,153,0.1); color:#6ee7b7; }
        .badge-seller { background:rgba(167,139,250,0.1); color:#c4b5fd; }
        .badge-admin { background:rgba(245,158,11,0.1); color:#fcd34d; }
        .badge-available { background:rgba(52,211,153,0.1); color:#34d399; }
        .badge-sold { background:rgba(239,68,68,0.1); color:#f87171; }

        .user-av { width:30px; height:30px; border-radius:50%; background:linear-gradient(135deg,#6366f1,#a855f7); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; flex-shrink:0; }
        .price-text { font-weight:700; color:#c084fc; }

        /* ACTION BTNS */
        .tbl-btn { padding:4px 10px; border-radius:6px; font-size:11px; font-weight:600; cursor:pointer; text-decoration:none; transition:all 0.2s; border:0.5px solid transparent; display:inline-flex; align-items:center; gap:3px; font-family:'Inter',sans-serif; }
        .btn-view { background:rgba(99,102,241,0.1); color:#818cf8; border-color:rgba(99,102,241,0.25); }
        .btn-view:hover { background:rgba(99,102,241,0.2); }
        .btn-del { background:rgba(239,68,68,0.1); color:#f87171; border-color:rgba(239,68,68,0.25); }
        .btn-del:hover { background:rgba(239,68,68,0.2); }

        /* ACTIVITY */
        .activity-item { display:flex; align-items:flex-start; gap:12px; padding:13px 20px; border-bottom:0.5px solid rgba(255,255,255,0.04); }
        .activity-item:last-child { border-bottom:none; }
        .act-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; margin-top:4px; }
        .act-text { font-size:13px; color:rgba(255,255,255,0.6); line-height:1.5; }
        .act-text b { color:#fff; font-weight:600; }
        .act-time { font-size:11px; color:rgba(255,255,255,0.25); margin-top:3px; }

        /* EMPTY */
        .empty { padding:32px; text-align:center; color:rgba(255,255,255,0.25); font-size:13px; }

        /* FULL CARD */
        .full-card { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:16px; overflow:hidden; margin-bottom:24px; }

        /* CHART */
        .chart-wrap { padding:20px 22px; }

        /* DELETION REQUESTS */
        .del-item { display:flex; align-items:center; gap:10px; padding:13px 20px; border-bottom:0.5px solid rgba(255,255,255,0.04); }
        .del-item:last-child { border-bottom:none; }
        .del-name { font-size:13px; font-weight:600; color:#fff; }
        .del-email { font-size:11px; color:rgba(255,255,255,0.35); margin-top:2px; }
        .del-date { font-size:11px; color:#f87171; margin-left:auto; flex-shrink:0; }

        @media(max-width:768px) { .sidebar { display:none; } .main { margin-left:0; padding:20px 16px; } .stats-grid { grid-template-columns:repeat(2,1fr); } .actions-grid { grid-template-columns:repeat(3,1fr); } }
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
      <a href="{{ route('admin.dashboard') }}" class="sb-link active">
        <span class="sb-link-icon">⚡</span> Dashboard
      </a>
      <div class="sb-label" style="margin-top:8px;">Management</div>
      <a href="{{ route('admin.users') }}" class="sb-link">
        <span class="sb-link-icon">👥</span> Users
        @if(isset($deletionRequests) && $deletionRequests->count() > 0)
          <span class="sb-link-badge">{{ $deletionRequests->count() }}</span>
        @endif
      </a>
      <a href="{{ route('admin.books') }}" class="sb-link">
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

    <!-- TOPBAR -->
    <div class="topbar">
      <div class="topbar-left">
        <h1>Admin Dashboard ⚡</h1>
        <p>{{ now()->format('l, d F Y') }} · Welcome back, {{ auth()->user()->name }}!</p>
      </div>
      <div class="topbar-right">
        <a href="{{ route('home') }}" class="btn-site">🌐 View Site</a>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <!-- STATS -->
    <div class="stats-grid">
      <div class="stat-card indigo">
        <div class="stat-top">
          <div class="stat-icon indigo">👥</div>
        </div>
        <div class="stat-val">{{ $totalUsers }}</div>
        <div class="stat-label">Total Users</div>
      </div>
      <div class="stat-card purple">
        <div class="stat-top">
          <div class="stat-icon purple">📚</div>
        </div>
        <div class="stat-val">{{ $totalBooks }}</div>
        <div class="stat-label">Total Books</div>
      </div>
      <div class="stat-card green">
        <div class="stat-top">
          <div class="stat-icon green">🛒</div>
        </div>
        <div class="stat-val">{{ $totalOrders }}</div>
        <div class="stat-label">Total Orders</div>
      </div>
      <div class="stat-card orange">
        <div class="stat-top">
          <div class="stat-icon orange">💰</div>
        </div>
        <div class="stat-val">৳{{ number_format($totalRevenue,0) }}</div>
        <div class="stat-label">Total Revenue</div>
      </div>
      <div class="stat-card pink">
        <div class="stat-top">
          <div class="stat-icon pink">⏳</div>
        </div>
        <div class="stat-val">{{ $pendingOrders }}</div>
        <div class="stat-label">Pending Orders</div>
      </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="actions-grid">
      <a href="{{ route('admin.users') }}" class="action-btn">
        <span class="action-btn-icon">👥</span>
        <span class="action-btn-label">Manage Users</span>
      </a>
      <a href="{{ route('admin.books') }}" class="action-btn">
        <span class="action-btn-icon">📚</span>
        <span class="action-btn-label">Manage Books</span>
      </a>
      <a href="{{ route('admin.orders') }}" class="action-btn">
        <span class="action-btn-icon">📦</span>
        <span class="action-btn-label">All Orders</span>
      </a>
      <a href="{{ route('admin.categories') }}" class="action-btn">
        <span class="action-btn-icon">🏷️</span>
        <span class="action-btn-label">Categories</span>
      </a>
      <a href="{{ route('home') }}" class="action-btn">
        <span class="action-btn-icon">🌐</span>
        <span class="action-btn-label">View Site</span>
      </a>
    </div>

    <!-- CHART + ACTIVITY -->
    <div class="two-col">
      <div class="card">
        <div class="card-header">
          <span class="card-title">📈 Monthly Orders & Revenue</span>
        </div>
        <div class="chart-wrap">
          <canvas id="salesChart" height="120"></canvas>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <span class="card-title">🔔 Recent Activity</span>
        </div>
        @if($recentOrders->isEmpty())
          <div class="empty">No activity yet</div>
        @else
          @foreach($recentOrders->take(6) as $order)
            <div class="activity-item">
              <div class="act-dot" style="background:{{ $order->status === 'delivered' ? '#34d399' : ($order->status === 'pending' ? '#fbbf24' : '#818cf8') }};"></div>
              <div>
                <div class="act-text"><b>{{ $order->buyer->name ?? 'Someone' }}</b> ordered <b>{{ Str::limit($order->book->title ?? 'a book', 20) }}</b></div>
                <div class="act-time">{{ $order->created_at->diffForHumans() }} · ৳{{ number_format($order->price,0) }}</div>
              </div>
            </div>
          @endforeach
        @endif
      </div>
    </div>

    <!-- RECENT USERS + RECENT ORDERS -->
    <div class="two-col">

      <!-- RECENT USERS -->
      <div class="full-card">
        <div class="card-header">
          <span class="card-title">👥 Recent Users</span>
          <a href="{{ route('admin.users') }}" class="card-link">View all →</a>
        </div>
        @if($recentUsers->isEmpty())
          <div class="empty">No users yet</div>
        @else
          <table>
            <thead><tr><th>User</th><th>Role</th><th>Joined</th><th>Action</th></tr></thead>
            <tbody>
              @foreach($recentUsers as $u)
                <tr>
                  <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                      <div class="user-av">{{ strtoupper(substr($u->name,0,1)) }}</div>
                      <div>
                        <div style="font-weight:600;color:#fff;font-size:13px;">{{ $u->name }}</div>
                        <div style="font-size:11px;color:rgba(255,255,255,0.35);">{{ $u->email }}</div>
                      </div>
                    </div>
                  </td>
                  <td><span class="badge badge-{{ $u->role }}">{{ ucfirst($u->role) }}</span></td>
                  <td style="color:rgba(255,255,255,0.4);font-size:12px;">{{ $u->created_at->format('d M Y') }}</td>
                  <td>
                    <a href="{{ route('admin.users') }}" class="tbl-btn btn-view">👁️ View</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>

      <!-- DELETION REQUESTS -->
      <div class="full-card">
        <div class="card-header">
          <span class="card-title">⚠️ Deletion Requests</span>
          @if(isset($deletionRequests))
            <span style="font-size:12px;color:#f87171;font-weight:600;">{{ $deletionRequests->count() }} pending</span>
          @endif
        </div>
        @if(!isset($deletionRequests) || $deletionRequests->isEmpty())
          <div class="empty">No deletion requests 🎉</div>
        @else
          @foreach($deletionRequests as $u)
            <div class="del-item">
              <div class="user-av" style="background:rgba(239,68,68,0.2);color:#f87171;">{{ strtoupper(substr($u->name,0,1)) }}</div>
              <div>
                <div class="del-name">{{ $u->name }}</div>
                <div class="del-email">{{ $u->email }}</div>
              </div>
              <div class="del-date">{{ $u->delete_requested_at->addDays(7)->format('d M') }}</div>
            </div>
          @endforeach
        @endif
      </div>
    </div>

    <!-- RECENT ORDERS FULL -->
    <div class="full-card">
      <div class="card-header">
        <span class="card-title">🛒 Recent Orders</span>
        <a href="{{ route('admin.orders') }}" class="card-link">View all →</a>
      </div>
      @if($recentOrders->isEmpty())
        <div class="empty">No orders yet</div>
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
            </tr>
          </thead>
          <tbody>
            @foreach($recentOrders as $order)
              <tr>
                <td style="font-family:monospace;font-size:12px;color:rgba(255,255,255,0.4);">#{{ $order->id }}</td>
                <td style="font-weight:600;color:#fff;max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Str::limit($order->book->title ?? 'N/A',22) }}</td>
                <td style="color:rgba(255,255,255,0.6);">{{ $order->buyer->name ?? 'N/A' }}</td>
                <td style="color:rgba(255,255,255,0.6);">{{ $order->book->user->name ?? 'N/A' }}</td>
                <td><span class="price-text">৳{{ number_format($order->price,0) }}</span></td>
                <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                <td style="color:rgba(255,255,255,0.35);font-size:12px;">{{ $order->created_at->format('d M Y') }}</td>
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
const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const monthlyData = @json($monthlyOrders);
const labels = monthlyData.map(d => months[d.month - 1]);
const orderCounts = monthlyData.map(d => d.count);
const revenues = monthlyData.map(d => d.revenue);

const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Orders',
                data: orderCounts,
                backgroundColor: 'rgba(99,102,241,0.5)',
                borderColor: 'rgba(99,102,241,0.8)',
                borderWidth: 1.5,
                borderRadius: 6,
            },
            {
                label: 'Revenue (৳)',
                data: revenues,
                type: 'line',
                borderColor: '#c084fc',
                borderWidth: 2,
                pointBackgroundColor: '#c084fc',
                pointRadius: 4,
                tension: 0.4,
                fill: false,
                yAxisID: 'y1',
            }
        ]
    },
    options: {
        responsive: true,
        interaction: { mode:'index', intersect:false },
        plugins: {
            legend: { labels: { color:'rgba(255,255,255,0.5)', font:{ family:'Inter' } } },
            tooltip: {
                backgroundColor:'#1a1a2e',
                titleColor:'#fff',
                bodyColor:'rgba(255,255,255,0.7)',
                borderColor:'rgba(99,102,241,0.3)',
                borderWidth:1,
            }
        },
        scales: {
            x: { ticks:{ color:'rgba(255,255,255,0.4)', font:{ family:'Inter' } }, grid:{ color:'rgba(255,255,255,0.05)' } },
            y: { ticks:{ color:'rgba(255,255,255,0.4)', font:{ family:'Inter' } }, grid:{ color:'rgba(255,255,255,0.05)' } },
            y1: { position:'right', ticks:{ color:'rgba(255,255,255,0.3)', font:{ family:'Inter' }, callback: v => '৳'+v }, grid:{ display:false } }
        }
    }
});
</script>
</body>
</html>