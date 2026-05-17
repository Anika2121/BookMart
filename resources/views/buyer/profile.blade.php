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
        .sb-user-info { padding:16px 20px; border-bottom:0.5px solid rgba(255,255,255,0.06); }
        .sb-avatar { width:40px; height:40px; border-radius:50%; background:linear-gradient(135deg,#7c3aed,#a855f7); display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:800; margin-bottom:8px; overflow:hidden; }
        .sb-avatar img { width:100%; height:100%; object-fit:cover; }
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

        .main { margin-left:240px; flex:1; padding:28px 32px; max-width:calc(100% - 240px); }
        .topbar { margin-bottom:28px; }
        .topbar h1 { font-size:22px; font-weight:700; color:#fff; letter-spacing:-0.4px; }
        .topbar p { font-size:13px; color:rgba(255,255,255,0.35); margin-top:3px; }

        .alert { padding:12px 18px; border-radius:12px; margin-bottom:20px; font-size:13px; display:flex; align-items:center; gap:8px; }
        .alert-success { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#6ee7b7; }
        .alert-error { background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#fca5a5; }

        .profile-grid { display:grid; grid-template-columns:300px 1fr; gap:24px; }
        @media(max-width:1000px) { .profile-grid { grid-template-columns:1fr; } }

        .profile-card { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:16px; overflow:hidden; height:fit-content; }
        .profile-cover { height:80px; background:linear-gradient(135deg,#7c3aed,#4f46e5,#0ea5e9); }
        .profile-avatar-wrap { padding:0 22px; margin-top:-32px; margin-bottom:16px; }
        .profile-avatar { width:64px; height:64px; border-radius:50%; background:linear-gradient(135deg,#7c3aed,#a855f7); display:flex; align-items:center; justify-content:center; font-size:26px; font-weight:800; border:3px solid #0f0f1e; overflow:hidden; cursor:pointer; transition:all 0.2s; }
        .profile-avatar:hover { opacity:0.85; }
        .profile-avatar img { width:100%; height:100%; object-fit:cover; }
        .profile-body { padding:0 22px 22px; }
        .profile-name { font-size:18px; font-weight:700; color:#fff; margin-bottom:4px; }
        .profile-email { font-size:12px; color:rgba(255,255,255,0.35); margin-bottom:12px; }
        .profile-badges { display:flex; flex-direction:column; gap:8px; margin-bottom:18px; }
        .pbadge { display:inline-flex; align-items:center; gap:5px; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:600; width:fit-content; }
        .pbadge-buyer { background:rgba(52,211,153,0.1); color:#6ee7b7; border:0.5px solid rgba(52,211,153,0.2); }
        .pbadge-del { background:rgba(239,68,68,0.1); color:#f87171; border:0.5px solid rgba(239,68,68,0.2); }
        .profile-stats { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
        .pstat { background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.07); border-radius:10px; padding:12px; text-align:center; }
        .pstat-val { font-size:20px; font-weight:800; color:#a78bfa; }
        .pstat-label { font-size:11px; color:rgba(255,255,255,0.35); margin-top:3px; }

        .right-col { display:flex; flex-direction:column; gap:20px; }

        .form-card { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:16px; overflow:hidden; }
        .card-header { padding:18px 22px; border-bottom:0.5px solid rgba(255,255,255,0.06); display:flex; align-items:center; justify-content:space-between; }
        .card-title { font-size:15px; font-weight:700; color:#fff; }
        .card-count { font-size:12px; color:rgba(255,255,255,0.3); background:rgba(255,255,255,0.05); padding:3px 10px; border-radius:20px; }
        .form-body { padding:22px; }

        .field { margin-bottom:14px; }
        .field label { display:block; font-size:11px; font-weight:600; color:rgba(255,255,255,0.35); margin-bottom:7px; text-transform:uppercase; letter-spacing:0.6px; }
        .field input, .field select { width:100%; padding:11px 14px; background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.1); border-radius:10px; color:#fff; font-size:14px; font-family:'Inter',sans-serif; outline:none; transition:all 0.2s; }
        .field input:focus, .field select:focus { border-color:rgba(124,58,237,0.5); background:rgba(124,58,237,0.05); box-shadow:0 0 0 3px rgba(124,58,237,0.1); }
        .field input::placeholder { color:rgba(255,255,255,0.2); }
        .field input:disabled { opacity:0.4; cursor:not-allowed; }
        .field select option { background:#0f0f1e; }
        .field-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .field-hint { font-size:11px; color:rgba(255,255,255,0.25); margin-top:5px; }
        .field-error { font-size:11px; color:#f87171; margin-top:4px; }

        .upload-zone { border:1.5px dashed rgba(255,255,255,0.1); border-radius:10px; padding:16px; text-align:center; cursor:pointer; transition:all 0.2s; position:relative; background:rgba(255,255,255,0.02); }
        .upload-zone:hover { border-color:rgba(124,58,237,0.4); background:rgba(124,58,237,0.04); }
        .upload-zone input { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
        .upload-zone-text { font-size:12px; color:rgba(255,255,255,0.35); }
        .upload-zone-text strong { color:#a78bfa; }

        .btn-save { padding:11px 24px; background:linear-gradient(135deg,#7c3aed,#a855f7); border:none; border-radius:10px; color:#fff; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .btn-save:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(124,58,237,0.4); }
        .btn-danger-sm { padding:11px 24px; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); border-radius:10px; color:#f87171; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .btn-danger-sm:hover { background:rgba(239,68,68,0.2); }
        .btn-success-sm { padding:11px 24px; background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); border-radius:10px; color:#6ee7b7; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .btn-success-sm:hover { background:rgba(52,211,153,0.2); }
        .btn-add { display:flex; align-items:center; gap:7px; padding:10px 18px; background:rgba(124,58,237,0.1); border:1px solid rgba(124,58,237,0.2); border-radius:10px; color:#a78bfa; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .btn-add:hover { background:rgba(124,58,237,0.2); }

        .addr-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:12px; margin-bottom:16px; }
        .addr-card { background:rgba(255,255,255,0.03); border:0.5px solid rgba(255,255,255,0.08); border-radius:12px; padding:16px; position:relative; transition:all 0.2s; }
        .addr-card.is-default { border-color:rgba(124,58,237,0.35); background:rgba(124,58,237,0.06); }
        .addr-card:hover { border-color:rgba(255,255,255,0.14); }
        .addr-badge { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:20px; font-size:10px; font-weight:700; margin-bottom:8px; }
        .addr-badge-home { background:rgba(96,165,250,0.12); color:#60a5fa; }
        .addr-badge-office { background:rgba(251,191,36,0.12); color:#fbbf24; }
        .addr-badge-other { background:rgba(167,139,250,0.12); color:#a78bfa; }
        .addr-default-tag { position:absolute; top:12px; right:12px; font-size:10px; font-weight:700; color:#a78bfa; background:rgba(124,58,237,0.15); padding:2px 8px; border-radius:20px; }
        .addr-name { font-size:13px; font-weight:700; color:#fff; margin-bottom:3px; }
        .addr-phone { font-size:11px; color:rgba(255,255,255,0.4); margin-bottom:8px; }
        .addr-text { font-size:12px; color:rgba(255,255,255,0.55); line-height:1.6; }
        .addr-actions { display:flex; gap:6px; margin-top:12px; padding-top:12px; border-top:0.5px solid rgba(255,255,255,0.06); flex-wrap:wrap; }
        .addr-btn { padding:5px 12px; border-radius:7px; font-size:11px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; border:0.5px solid transparent; }
        .addr-btn-default { background:rgba(124,58,237,0.1); color:#a78bfa; border-color:rgba(124,58,237,0.2); }
        .addr-btn-default:hover { background:rgba(124,58,237,0.2); }
        .addr-btn-del { background:rgba(239,68,68,0.1); color:#f87171; border-color:rgba(239,68,68,0.2); }
        .addr-btn-del:hover { background:rgba(239,68,68,0.2); }

        .add-form { background:rgba(255,255,255,0.02); border:1px dashed rgba(255,255,255,0.08); border-radius:12px; padding:20px; margin-top:14px; display:none; }
        .add-form.show { display:block; }

        .danger-box { background:rgba(239,68,68,0.06); border:0.5px solid rgba(239,68,68,0.2); border-radius:12px; padding:20px; }
        .danger-box h3 { font-size:14px; font-weight:700; color:#f87171; margin-bottom:8px; }
        .danger-box p { font-size:13px; color:rgba(255,255,255,0.45); line-height:1.6; margin-bottom:14px; }
        .countdown-box { background:rgba(239,68,68,0.08); border-radius:8px; padding:10px 14px; font-size:12px; color:#fca5a5; font-weight:600; margin-bottom:14px; }

        @media(max-width:768px) { .sidebar { display:none; } .main { margin-left:0; padding:20px 16px; max-width:100%; } .field-row { grid-template-columns:1fr; } }
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
    <div class="sb-user-info">
      <div class="sb-avatar">
        @if($user->photo ?? $user->avatar ?? null)
          <img src="{{ Str::startsWith($user->photo ?? $user->avatar, 'http') ? ($user->photo ?? $user->avatar) : Storage::url($user->photo ?? $user->avatar) }}" alt="{{ $user->name }}">
        @else
          {{ strtoupper(substr($user->name,0,1)) }}
        @endif
      </div>
      <div class="sb-name">{{ $user->name }}</div>
      <div class="sb-role"><span class="sb-role-dot"></span> Verified Buyer</div>
    </div>
    <nav class="sb-nav">
      <div class="sb-section-label">Main</div>
      <a href="{{ route('buyer.dashboard') }}" class="sb-link">
        <span class="sb-link-icon">📊</span> Dashboard
      </a>
      <a href="{{ route('books.index') }}" class="sb-link">
        <span class="sb-link-icon">📚</span> Browse Books
      </a>
      <div class="sb-section-label" style="margin-top:8px;">Shopping</div>
      <a href="{{ route('orders.my') }}" class="sb-link">
        <span class="sb-link-icon">📦</span> My Orders
      </a>
      <a href="{{ route('wishlist.index') }}" class="sb-link">
        <span class="sb-link-icon">❤️</span> Wishlist
      </a>
      <a href="{{ route('cart.index') }}" class="sb-link">
        <span class="sb-link-icon">🛒</span> Cart
      </a>
      <div class="sb-section-label" style="margin-top:8px;">Account</div>
      <a href="{{ route('buyer.profile') }}" class="sb-link active">
        <span class="sb-link-icon">👤</span> Profile
      </a>
      <a href="{{ route('addresses.index') }}" class="sb-link">
        <span class="sb-link-icon">📍</span> Addresses
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
      <h1>My Profile 👤</h1>
      <p>Manage your personal information and delivery addresses</p>
    </div>

    @if(session('success'))
      <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif

    <div class="profile-grid">

      <!-- LEFT: Profile Card -->
      <div>
        <div class="profile-card">
          <div class="profile-cover"></div>
          <div class="profile-avatar-wrap">
            <label for="photo_trigger" style="cursor:pointer;">
              <div class="profile-avatar" title="Click to change photo">
                @if($user->photo ?? $user->avatar ?? null)
                  <img src="{{ Str::startsWith($user->photo ?? $user->avatar, 'http') ? ($user->photo ?? $user->avatar) : Storage::url($user->photo ?? $user->avatar) }}" alt="{{ $user->name }}">
                @else
                  {{ strtoupper(substr($user->name,0,1)) }}
                @endif
              </div>
            </label>
          </div>
          <div class="profile-body">
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-email">{{ $user->email }}</div>
            <div class="profile-badges">
              <span class="pbadge pbadge-buyer">✅ Verified Buyer</span>
              @if($user->hasRequestedDeletion())
                <span class="pbadge pbadge-del">⚠️ Deletion Pending</span>
              @endif
            </div>
            <div class="profile-stats">
              <div class="pstat">
                <div class="pstat-val">{{ $user->buyerOrders()->count() }}</div>
                <div class="pstat-label">Orders</div>
              </div>
              <div class="pstat">
                <div class="pstat-val">{{ $user->buyerOrders()->where('status','delivered')->count() }}</div>
                <div class="pstat-label">Delivered</div>
              </div>
              <div class="pstat">
                <div class="pstat-val">৳{{ number_format($user->buyerOrders()->whereIn('status',['confirmed','shipped','delivered'])->sum('price'),0) }}</div>
                <div class="pstat-label">Total Spent</div>
              </div>
              <div class="pstat">
                <div class="pstat-val">{{ $addresses->count() }}/5</div>
                <div class="pstat-label">Addresses</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT: Forms -->
      <div class="right-col">

        <!-- Personal Info -->
        <div class="form-card">
          <div class="card-header">
            <span class="card-title">✏️ Personal Information</span>
          </div>
          <div class="form-body">
            <form method="POST" action="{{ route('buyer.profile.update') }}" enctype="multipart/form-data">
              @csrf
              <input type="file" id="photo_trigger" name="photo" accept="image/*" style="display:none" onchange="previewPhoto(this)">
              <div class="field-row" style="margin-bottom:14px;">
                <div class="field" style="margin-bottom:0;">
                  <label>Full Name</label>
                  <input type="text" name="name" value="{{ old('name',$user->name) }}" placeholder="Your full name" required>
                  @error('name')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field" style="margin-bottom:0;">
                  <label>Phone Number</label>
                  <input type="text" name="phone" value="{{ old('phone',$user->phone) }}" placeholder="01XXXXXXXXX">
                  @error('phone')<div class="field-error">{{ $message }}</div>@enderror
                </div>
              </div>
              <div class="field">
                <label>Email Address</label>
                <input type="email" value="{{ $user->email }}" disabled>
                <div class="field-hint">Email cannot be changed</div>
              </div>
              <div class="field" id="photoFieldWrap" style="display:none;">
                <label>New Profile Photo</label>
                <div class="upload-zone" onclick="document.getElementById('photo_trigger').click()">
                  <div class="upload-zone-text">📷 <span id="photoFileName">Click to browse</span> — <strong>PNG, JPG up to 2MB</strong></div>
                  <img id="photoPreview" src="" style="max-height:80px;border-radius:8px;margin-top:10px;display:none;">
                </div>
              </div>
              <div style="display:flex;gap:10px;margin-top:4px;">
                <button type="submit" class="btn-save">💾 Save Changes</button>
                <label for="photo_trigger" style="cursor:pointer;" class="btn-add">📷 Change Photo</label>
              </div>
            </form>
          </div>
        </div>

        <!-- Change Password -->
        <div class="form-card">
          <div class="card-header">
            <span class="card-title">🔒 Change Password</span>
          </div>
          <div class="form-body">
            <form method="POST" action="{{ route('buyer.profile.update') }}">
              @csrf
              <input type="hidden" name="change_password" value="1">
              <div class="field">
                <label>Current Password</label>
                <input type="password" name="current_password" placeholder="Enter current password">
                @error('current_password')<div class="field-error">{{ $message }}</div>@enderror
              </div>
              <div class="field-row">
                <div class="field" style="margin-bottom:0;">
                  <label>New Password</label>
                  <input type="password" name="password" placeholder="Min 8 characters">
                  @error('password')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field" style="margin-bottom:0;">
                  <label>Confirm Password</label>
                  <input type="password" name="password_confirmation" placeholder="Repeat new password">
                </div>
              </div>
              <div style="margin-top:16px;">
                <button type="submit" class="btn-danger-sm">🔒 Update Password</button>
              </div>
            </form>
          </div>
        </div>

        <!-- Delivery Addresses -->
        <div class="form-card">
          <div class="card-header">
            <span class="card-title">📍 Delivery Addresses</span>
            <span class="card-count">{{ $addresses->count() }} / 5</span>
          </div>
          <div class="form-body">
            @if($addresses->count() > 0)
              <div class="addr-grid">
                @foreach($addresses as $addr)
                  <div class="addr-card {{ $addr->is_default ? 'is-default' : '' }}">
                    @if($addr->is_default)
                      <span class="addr-default-tag">⭐ Default</span>
                    @endif
                    @php $lc = strtolower($addr->label); @endphp
                    <span class="addr-badge addr-badge-{{ $lc === 'home' ? 'home' : ($lc === 'office' ? 'office' : 'other') }}">
                      {{ $lc === 'home' ? '🏠' : ($lc === 'office' ? '🏢' : '📌') }} {{ $addr->label }}
                    </span>
                    <div class="addr-name">{{ $addr->recipient_name }}</div>
                    <div class="addr-phone">📞 {{ $addr->phone }}</div>
                    <div class="addr-text">{{ $addr->address_line }}, {{ $addr->city }}, {{ $addr->district }}@if($addr->postal_code) — {{ $addr->postal_code }}@endif</div>
                    <div class="addr-actions">
                      @if(!$addr->is_default)
                        <form method="POST" action="{{ route('addresses.default',$addr) }}" style="margin:0;">
                          @csrf @method('PATCH')
                          <button type="submit" class="addr-btn addr-btn-default">⭐ Set Default</button>
                        </form>
                      @endif
                      <form method="POST" action="{{ route('addresses.destroy',$addr) }}" style="margin:0;" onsubmit="return confirm('Delete this address?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="addr-btn addr-btn-del">🗑️ Delete</button>
                      </form>
                    </div>
                  </div>
                @endforeach
              </div>
            @else
              <div style="text-align:center;padding:28px;color:rgba(255,255,255,0.25);">
                <div style="font-size:32px;margin-bottom:8px;">📍</div>
                <p style="font-size:13px;">No addresses saved yet</p>
              </div>
            @endif

            @if($addresses->count() < 5)
              <button class="btn-add" onclick="toggleAddForm()" id="addAddrBtn">➕ Add New Address</button>
              <div class="add-form" id="addAddrForm">
                <form method="POST" action="{{ route('addresses.store') }}">
                  @csrf
                  <div class="field-row" style="margin-bottom:12px;">
                    <div class="field" style="margin-bottom:0;">
                      <label>Label</label>
                      <select name="label" required>
                        <option value="">Select type</option>
                        <option value="Home">🏠 Home</option>
                        <option value="Office">🏢 Office</option>
                        <option value="Other">📌 Other</option>
                      </select>
                    </div>
                    <div class="field" style="margin-bottom:0;">
                      <label>Recipient Name</label>
                      <input type="text" name="recipient_name" placeholder="Full name" required>
                    </div>
                  </div>
                  <div class="field-row" style="margin-bottom:12px;">
                    <div class="field" style="margin-bottom:0;">
                      <label>Phone</label>
                      <input type="text" name="phone" placeholder="01XXXXXXXXX" required>
                    </div>
                    <div class="field" style="margin-bottom:0;">
                      <label>Postal Code</label>
                      <input type="text" name="postal_code" placeholder="Optional">
                    </div>
                  </div>
                  <div class="field">
                    <label>Address Line</label>
                    <input type="text" name="address_line" placeholder="House, Street, Area" required>
                  </div>
                  <div class="field-row" style="margin-bottom:12px;">
                    <div class="field" style="margin-bottom:0;">
                      <label>City</label>
                      <input type="text" name="city" placeholder="Dhaka" required>
                    </div>
                    <div class="field" style="margin-bottom:0;">
                      <label>District</label>
                      <input type="text" name="district" placeholder="Dhaka" required>
                    </div>
                  </div>
                  <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
                    <input type="checkbox" name="is_default" value="1" id="isDefault" style="width:14px;height:14px;accent-color:#7c3aed;">
                    <label for="isDefault" style="font-size:13px;color:rgba(255,255,255,0.55);cursor:pointer;">Set as default address</label>
                  </div>
                  <div style="display:flex;gap:8px;">
                    <button type="submit" class="btn-save" style="font-size:12px;padding:9px 18px;">💾 Save Address</button>
                    <button type="button" onclick="toggleAddForm()" class="btn-danger-sm" style="font-size:12px;padding:9px 18px;">Cancel</button>
                  </div>
                </form>
              </div>
            @else
              <div style="font-size:12px;color:rgba(255,165,0,0.7);margin-top:10px;padding:9px 14px;background:rgba(255,165,0,0.06);border-radius:8px;border:0.5px solid rgba(255,165,0,0.15);">
                ⚠️ Maximum 5 addresses allowed. Delete one to add another.
              </div>
            @endif
          </div>
        </div>

        <!-- Danger Zone -->
        <div class="form-card">
          <div class="card-header">
            <span class="card-title">⚠️ Danger Zone</span>
          </div>
          <div class="form-body">
            <div class="danger-box">
              <h3>🗑️ Delete Account</h3>
              @if($user->hasRequestedDeletion())
                <p>Your deletion request has been submitted. Your account will be automatically deleted <strong style="color:#fca5a5;">{{ $user->delete_requested_at->addDays(7)->diffForHumans() }}</strong>.</p>
                <div class="countdown-box">⏳ Scheduled: {{ $user->delete_requested_at->addDays(7)->format('d M Y, h:i A') }}</div>
                <form method="POST" action="{{ route('buyer.delete.cancel') }}">
                  @csrf
                  <button type="submit" class="btn-success-sm">✅ Cancel Deletion Request</button>
                </form>
              @else
                <p>All your data, orders, and reviews will be permanently deleted and cannot be recovered. You have 7 days to cancel after requesting.</p>
                <form method="POST" action="{{ route('buyer.delete.request') }}" onsubmit="return confirm('Are you sure? Account will be deleted after 7 days.')">
                  @csrf
                  <button type="submit" class="btn-danger-sm">🗑️ Request Account Deletion</button>
                </form>
              @endif
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>
</div>

<script>
function toggleAddForm() {
  const form = document.getElementById('addAddrForm');
  const btn = document.getElementById('addAddrBtn');
  form.classList.toggle('show');
  btn.textContent = form.classList.contains('show') ? '✖ Cancel' : '➕ Add New Address';
}

function previewPhoto(input) {
  if (input.files && input.files[0]) {
    document.getElementById('photoFieldWrap').style.display = 'block';
    document.getElementById('photoFileName').textContent = input.files[0].name;
    const reader = new FileReader();
    reader.onload = e => {
      const preview = document.getElementById('photoPreview');
      preview.src = e.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
</body>
</html>