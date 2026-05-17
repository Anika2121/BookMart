<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
    <title>My Profile - BookMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#09090f; color:#fff; min-height:100vh; }
        ::-webkit-scrollbar { width:5px; }
        ::-webkit-scrollbar-thumb { background:rgba(124,58,237,0.4); border-radius:4px; }
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
        .sb-bottom { padding:16px; border-top:0.5px solid rgba(255,255,255,0.06); }
        .sb-logout { width:100%; padding:10px; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); border-radius:10px; color:#f87171; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .sb-logout:hover { background:rgba(239,68,68,0.2); }
        .main { margin-left:240px; flex:1; padding:28px 32px; }
        .topbar { margin-bottom:28px; }
        .topbar h1 { font-size:22px; font-weight:700; color:#fff; letter-spacing:-0.4px; }
        .topbar p { font-size:13px; color:rgba(255,255,255,0.35); margin-top:3px; }
        .alert { padding:12px 18px; border-radius:12px; margin-bottom:24px; font-size:13px; display:flex; align-items:center; gap:8px; }
        .alert-success { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#6ee7b7; }
        .alert-error { background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#fca5a5; }
        .profile-grid { display:grid; grid-template-columns:300px 1fr; gap:24px; }
        @media(max-width:900px) { .profile-grid { grid-template-columns:1fr; } }
        .profile-card { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:16px; overflow:hidden; }
        .profile-cover { height:80px; background:linear-gradient(135deg,#7c3aed,#4f46e5,#0ea5e9); }
        .profile-avatar-wrap { padding:0 22px; margin-top:-32px; margin-bottom:16px; }
        .profile-avatar { width:64px; height:64px; border-radius:50%; background:linear-gradient(135deg,#7c3aed,#a855f7); display:flex; align-items:center; justify-content:center; font-size:26px; font-weight:800; border:3px solid #0f0f1e; overflow:hidden; }
        .profile-avatar img { width:100%; height:100%; object-fit:cover; }
        .profile-info { padding:0 22px 22px; }
        .profile-name { font-size:18px; font-weight:700; color:#fff; margin-bottom:4px; }
        .profile-email { font-size:12px; color:rgba(255,255,255,0.35); margin-bottom:16px; }
        .profile-stats { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
        .pstat { background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.07); border-radius:10px; padding:12px; text-align:center; }
        .pstat-val { font-size:20px; font-weight:800; color:#a78bfa; }
        .pstat-label { font-size:11px; color:rgba(255,255,255,0.35); margin-top:3px; }
        .form-card { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:16px; overflow:hidden; margin-bottom:20px; }
        .card-header { padding:18px 22px; border-bottom:0.5px solid rgba(255,255,255,0.06); }
        .card-title { font-size:15px; font-weight:700; color:#fff; }
        .form-body { padding:22px; }
        .field { margin-bottom:16px; }
        .field label { display:block; font-size:11px; font-weight:600; color:rgba(255,255,255,0.35); margin-bottom:7px; text-transform:uppercase; letter-spacing:0.6px; }
        .field input { width:100%; padding:12px 14px; background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.1); border-radius:10px; color:#fff; font-size:14px; font-family:'Inter',sans-serif; outline:none; transition:all 0.2s; }
        .field input:focus { border-color:rgba(124,58,237,0.5); background:rgba(124,58,237,0.05); box-shadow:0 0 0 3px rgba(124,58,237,0.1); }
        .field input::placeholder { color:rgba(255,255,255,0.2); }
        .field input[type="file"] { padding:10px; cursor:pointer; }
        .error-msg { font-size:11px; color:#f87171; margin-top:4px; }
        .field-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .btn-save { padding:12px 28px; background:linear-gradient(135deg,#7c3aed,#a855f7); border:none; border-radius:10px; color:#fff; font-size:14px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .btn-save:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(124,58,237,0.4); }
        .btn-danger { padding:12px 28px; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); border-radius:10px; color:#f87171; font-size:14px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .btn-danger:hover { background:rgba(239,68,68,0.2); }
        .badge-seller { display:inline-flex; align-items:center; gap:5px; padding:4px 12px; border-radius:20px; background:rgba(124,58,237,0.15); border:0.5px solid rgba(124,58,237,0.3); color:#a78bfa; font-size:11px; font-weight:600; margin-bottom:12px; }
        @media(max-width:768px) { .sidebar { display:none; } .main { margin-left:0; padding:20px 16px; } }
    </style>
</head>
<body>
<div class="layout">
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
      <a href="{{ route('orders.received') }}" class="sb-link">
        <span class="sb-link-icon">📦</span> Orders
      </a>
      <a href="{{ route('seller.dashboard') }}#my-listings" class="sb-link">
        <span class="sb-link-icon">📖</span> My Listings
      </a>
      <div class="sb-section-label" style="margin-top:8px;">Account</div>
      <a href="{{ route('seller.profile') }}" class="sb-link active">
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

  <main class="main">
    <div class="topbar">
      <h1>My Profile 👤</h1>
      <p>Manage your seller account information</p>
    </div>

    @if(session('success'))
      <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif

    <div class="profile-grid">
      <div>
        <div class="profile-card">
          <div class="profile-cover"></div>
          <div class="profile-avatar-wrap">
            <div class="profile-avatar">
              @if(auth()->user()->avatar)
                <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar">
              @else
                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
              @endif
            </div>
          </div>
          <div class="profile-info">
            <div class="badge-seller">📦 Verified Seller</div>
            <div class="profile-name">{{ auth()->user()->name }}</div>
            <div class="profile-email">{{ auth()->user()->email }}</div>
            <div class="profile-stats">
              <div class="pstat">
                <div class="pstat-val">{{ $totalBooks }}</div>
                <div class="pstat-label">Books Listed</div>
              </div>
              <div class="pstat">
                <div class="pstat-val">{{ $totalSales }}</div>
                <div class="pstat-label">Books Sold</div>
              </div>
              <div class="pstat">
                <div class="pstat-val">৳{{ number_format($totalEarnings,0) }}</div>
                <div class="pstat-label">Total Earned</div>
              </div>
              <div class="pstat">
                <div class="pstat-val">{{ $avgRating ? number_format($avgRating,1) : 'N/A' }}</div>
                <div class="pstat-label">Avg Rating</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div>
        <div class="form-card">
          <div class="card-header">
            <div class="card-title">✏️ Update Profile</div>
          </div>
          <div class="form-body">
            <form method="POST" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data">
              @csrf
              <div class="field-row">
                <div class="field">
                  <label>Full Name</label>
                  <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" placeholder="Your name" required>
                  @error('name')<div class="error-msg">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                  <label>Phone Number</label>
                  <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="01XXXXXXXXX">
                  @error('phone')<div class="error-msg">{{ $message }}</div>@enderror
                </div>
              </div>
              <div class="field">
                <label>Email Address</label>
                <input type="email" value="{{ auth()->user()->email }}" disabled style="opacity:0.4;cursor:not-allowed;">
              </div>
              <div class="field">
                <label>Profile Photo</label>
                <input type="file" name="avatar" accept="image/*">
                @error('avatar')<div class="error-msg">{{ $message }}</div>@enderror
              </div>
              <button type="submit" class="btn-save">💾 Save Changes</button>
            </form>
          </div>
        </div>

        <div class="form-card">
          <div class="card-header">
            <div class="card-title">🔒 Change Password</div>
          </div>
          <div class="form-body">
            <form method="POST" action="{{ route('seller.password.update') }}">
              @csrf
              <div class="field">
                <label>Current Password</label>
                <input type="password" name="current_password" placeholder="Enter current password" required>
                @error('current_password')<div class="error-msg">{{ $message }}</div>@enderror
              </div>
              <div class="field-row">
                <div class="field">
                  <label>New Password</label>
                  <input type="password" name="password" placeholder="Min 8 characters" required>
                  @error('password')<div class="error-msg">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                  <label>Confirm Password</label>
                  <input type="password" name="password_confirmation" placeholder="Repeat new password" required>
                </div>
              </div>
              <button type="submit" class="btn-danger">🔒 Update Password</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
</body>
</html>