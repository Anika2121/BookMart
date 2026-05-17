<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
    <title>Manage Users - BookMart Admin</title>
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

        .user-cell { display:flex; align-items:center; gap:10px; }
        .user-av { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; flex-shrink:0; overflow:hidden; }
        .user-av img { width:100%; height:100%; object-fit:cover; }
        .user-name { font-size:13px; font-weight:600; color:#fff; }
        .user-email { font-size:11px; color:rgba(255,255,255,0.35); margin-top:2px; }

        .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600; }
        .badge-buyer { background:rgba(96,165,250,0.12); color:#60a5fa; border:0.5px solid rgba(96,165,250,0.25); }
        .badge-seller { background:rgba(167,139,250,0.12); color:#a78bfa; border:0.5px solid rgba(167,139,250,0.25); }
        .badge-admin { background:rgba(251,191,36,0.12); color:#fbbf24; border:0.5px solid rgba(251,191,36,0.25); }
        .badge-active { background:rgba(52,211,153,0.12); color:#34d399; border:0.5px solid rgba(52,211,153,0.25); }
        .badge-banned { background:rgba(239,68,68,0.12); color:#f87171; border:0.5px solid rgba(239,68,68,0.25); }
        .badge-del { background:rgba(251,191,36,0.1); color:#fcd34d; border:0.5px solid rgba(251,191,36,0.2); }

        .tbl-btn { padding:5px 12px; border-radius:7px; font-size:11px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; border:0.5px solid transparent; }
        .btn-ban { background:rgba(239,68,68,0.1); color:#f87171; border-color:rgba(239,68,68,0.25); }
        .btn-ban:hover { background:rgba(239,68,68,0.2); }
        .btn-unban { background:rgba(52,211,153,0.1); color:#34d399; border-color:rgba(52,211,153,0.25); }
        .btn-unban:hover { background:rgba(52,211,153,0.2); }

        .empty { padding:48px; text-align:center; color:rgba(255,255,255,0.25); }
        .empty-icon { font-size:36px; margin-bottom:10px; }

        .pagination-wrap { padding:14px 20px; border-top:0.5px solid rgba(255,255,255,0.05); }
        .pagination-wrap .pagination { display:flex; gap:6px; }
        .pagination-wrap .page-link { padding:6px 12px; background:rgba(255,255,255,0.05); border:0.5px solid rgba(255,255,255,0.1); border-radius:7px; color:rgba(255,255,255,0.5); font-size:12px; text-decoration:none; transition:all 0.2s; }
        .pagination-wrap .page-link:hover { background:rgba(99,102,241,0.15); color:#818cf8; }
        .pagination-wrap .active .page-link { background:rgba(99,102,241,0.2); border-color:rgba(99,102,241,0.4); color:#818cf8; }

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
      <a href="{{ route('admin.users') }}" class="sb-link active">
        <span class="sb-link-icon">👥</span> Users
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
    <div class="topbar">
      <div>
        <h1>👥 Manage Users</h1>
        <p>View, search and manage all registered users</p>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <!-- STATS -->
    <div class="stats-row">
      <div class="stat">
        <div class="stat-icon" style="background:rgba(99,102,241,0.15);">👥</div>
        <div>
          <div class="stat-val" style="color:#818cf8;">{{ $users->total() }}</div>
          <div class="stat-label">Total Users</div>
        </div>
      </div>
      <div class="stat">
        <div class="stat-icon" style="background:rgba(96,165,250,0.15);">🛒</div>
        <div>
          <div class="stat-val" style="color:#60a5fa;">{{ $users->getCollection()->where('role','buyer')->count() }}</div>
          <div class="stat-label">Buyers</div>
        </div>
      </div>
      <div class="stat">
        <div class="stat-icon" style="background:rgba(167,139,250,0.15);">📦</div>
        <div>
          <div class="stat-val" style="color:#a78bfa;">{{ $users->getCollection()->where('role','seller')->count() }}</div>
          <div class="stat-label">Sellers</div>
        </div>
      </div>
      <div class="stat">
        <div class="stat-icon" style="background:rgba(239,68,68,0.15);">🚫</div>
        <div>
          <div class="stat-val" style="color:#f87171;">{{ $users->getCollection()->where('role','banned')->count() }}</div>
          <div class="stat-label">Banned</div>
        </div>
      </div>
    </div>

    <!-- FILTER -->
    <form method="GET" action="{{ route('admin.users') }}" class="filter-bar">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Search by name or email..." class="search-input">
      <select name="role" class="filter-select">
        <option value="">All Roles</option>
        <option value="buyer" {{ request('role')==='buyer' ? 'selected' : '' }}>🛒 Buyers</option>
        <option value="seller" {{ request('role')==='seller' ? 'selected' : '' }}>📦 Sellers</option>
        <option value="admin" {{ request('role')==='admin' ? 'selected' : '' }}>⚙️ Admins</option>
        <option value="banned" {{ request('role')==='banned' ? 'selected' : '' }}>🚫 Banned</option>
      </select>
      <button type="submit" class="btn-search">🔍 Search</button>
      <a href="{{ route('admin.users') }}" class="btn-reset">Reset</a>
    </form>

    <!-- TABLE -->
    <div class="table-card">
      <div class="table-header">
        <span class="table-title">All Registered Users</span>
        <span class="table-count">{{ $users->total() }} users</span>
      </div>

      @if($users->isEmpty())
        <div class="empty">
          <div class="empty-icon">👥</div>
          <p>No users found</p>
        </div>
      @else
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>User</th>
              <th>Role</th>
              <th>Status</th>
              <th>Joined</th>
              <th>Books</th>
              <th>Orders</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $index => $u)
              @php
                $colors = ['#6366f1','#0ea5e9','#ec4899','#10b981','#f59e0b','#a855f7'];
                $color = $colors[$index % count($colors)];
              @endphp
              <tr>
                <td style="color:rgba(255,255,255,0.25);font-size:12px;">{{ $users->firstItem() + $index }}</td>
                <td>
                  <div class="user-cell">
                    <div class="user-av" style="background:{{ $color }}22;border:1px solid {{ $color }}44;color:{{ $color }};">
                      @if($u->photo ?? $u->avatar ?? null)
                        <img src="{{ Storage::url($u->photo ?? $u->avatar) }}" alt="{{ $u->name }}">
                      @else
                        {{ strtoupper(substr($u->name,0,1)) }}
                      @endif
                    </div>
                    <div>
                      <div class="user-name">{{ $u->name }}</div>
                      <div class="user-email">{{ $u->email }}</div>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="badge badge-{{ $u->role === 'banned' ? 'banned' : $u->role }}">
                    {{ $u->role === 'buyer' ? '🛒' : ($u->role === 'seller' ? '📦' : ($u->role === 'admin' ? '⚙️' : '🚫')) }}
                    {{ ucfirst($u->role) }}
                  </span>
                </td>
                <td>
                  @if($u->role === 'banned')
                    <span class="badge badge-banned">🚫 Banned</span>
                  @elseif($u->hasRequestedDeletion())
                    <span class="badge badge-del">⚠️ Del. Pending</span>
                  @else
                    <span class="badge badge-active">✅ Active</span>
                  @endif
                </td>
                <td style="color:rgba(255,255,255,0.4);font-size:12px;">{{ $u->created_at->format('d M Y') }}</td>
                <td style="text-align:center;color:rgba(255,255,255,0.5);">{{ $u->books->count() }}</td>
                <td style="text-align:center;color:rgba(255,255,255,0.5);">{{ $u->buyerOrders->count() }}</td>
                <td>
                  @if($u->role !== 'admin')
                    <form method="POST" action="{{ $u->role === 'banned' ? route('admin.users.unban',$u) : route('admin.users.ban',$u) }}" style="margin:0;" onsubmit="return confirm('{{ $u->role === 'banned' ? 'Unban' : 'Ban' }} {{ $u->name }}?')">
                      @csrf
                      @if($u->role === 'banned')
                        <button type="submit" class="tbl-btn btn-unban">✅ Unban</button>
                      @else
                        <button type="submit" class="tbl-btn btn-ban">🚫 Ban</button>
                      @endif
                    </form>
                  @else
                    <span style="color:rgba(255,255,255,0.2);font-size:12px;">— Admin</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div class="pagination-wrap">
          {{ $users->links() }}
        </div>
      @endif
    </div>
  </main>
</div>
</body>
</html>