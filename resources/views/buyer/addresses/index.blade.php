<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>??</text></svg>">
    <title>My Addresses - BookMart</title>
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
        .page { max-width:900px; margin:0 auto; padding:36px 24px; }
        .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; flex-wrap:wrap; gap:12px; }
        .page-header h1 { font-size:26px; font-weight:800; }
        .page-header p { color:rgba(255,255,255,0.4); font-size:13px; margin-top:4px; }

        /* Alerts */
        .alert { padding:12px 18px; border-radius:12px; margin-bottom:20px; font-size:14px; display:flex; align-items:center; gap:8px; }
        .alert-success { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#6ee7b7; }
        .alert-error { background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#fca5a5; }

        /* Count */
        .count-info { font-size:13px; color:rgba(255,255,255,0.4); background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:8px; padding:6px 14px; }
        .count-info span { color:#a78bfa; font-weight:700; }

        /* Address Grid */
        .address-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:16px; margin-bottom:24px; }

        /* Address Card */
        .address-card { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:16px; padding:20px; position:relative; transition:all 0.2s; }
        .address-card:hover { border-color:rgba(255,255,255,0.12); }
        .address-card.default { border-color:rgba(124,58,237,0.4); background:rgba(124,58,237,0.06); }

        .default-badge { position:absolute; top:14px; right:14px; font-size:10px; font-weight:700; color:#a78bfa; background:rgba(124,58,237,0.2); padding:3px 8px; border-radius:20px; }

        .address-label-badge { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:700; margin-bottom:12px; }
        .label-home { background:rgba(96,165,250,0.15); color:#93c5fd; border:1px solid rgba(96,165,250,0.2); }
        .label-office { background:rgba(251,191,36,0.15); color:#fcd34d; border:1px solid rgba(251,191,36,0.2); }
        .label-other { background:rgba(167,139,250,0.15); color:#c4b5fd; border:1px solid rgba(167,139,250,0.2); }

        .address-name { font-size:15px; font-weight:700; margin-bottom:4px; }
        .address-phone { font-size:13px; color:rgba(255,255,255,0.45); margin-bottom:10px; }
        .address-text { font-size:13px; color:rgba(255,255,255,0.6); line-height:1.6; }

        .address-actions { display:flex; gap:8px; margin-top:16px; padding-top:14px; border-top:1px solid rgba(255,255,255,0.06); flex-wrap:wrap; }
        .addr-btn { padding:7px 14px; border-radius:8px; border:none; font-size:12px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; display:inline-flex; align-items:center; gap:4px; }
        .addr-btn-default { background:rgba(124,58,237,0.15); color:#a78bfa; border:1px solid rgba(124,58,237,0.25); }
        .addr-btn-default:hover { background:rgba(124,58,237,0.25); }
        .addr-btn-delete { background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2); }
        .addr-btn-delete:hover { background:rgba(239,68,68,0.2); }

        /* Add Form */
        .add-section { background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.07); border-radius:16px; padding:24px; }
        .add-section-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
        .add-section-title { font-size:16px; font-weight:700; display:flex; align-items:center; gap:8px; }

        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px; }
        @media(max-width:600px) { .form-grid { grid-template-columns:1fr; } }

        .field-label { display:block; font-size:12px; font-weight:600; color:rgba(255,255,255,0.5); margin-bottom:7px; text-transform:uppercase; letter-spacing:0.5px; }
        .field-input { width:100%; padding:11px 14px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08); border-radius:10px; color:#fff; font-size:14px; font-family:'Inter',sans-serif; outline:none; transition:all 0.3s; }
        .field-input:focus { border-color:rgba(124,58,237,0.6); background:rgba(124,58,237,0.06); box-shadow:0 0 0 3px rgba(124,58,237,0.12); }
        .field-input::placeholder { color:rgba(255,255,255,0.2); }
        select.field-input { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='rgba(255,255,255,0.4)' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center; background-color:rgba(255,255,255,0.05); padding-right:32px; }
        select.field-input option { background:#1a1a2e; }

        .checkbox-row { display:flex; align-items:center; gap:10px; margin-bottom:16px; }
        .checkbox-row input { width:16px; height:16px; accent-color:#7c3aed; }
        .checkbox-row label { font-size:13px; color:rgba(255,255,255,0.6); cursor:pointer; }

        .btn-save { padding:12px 28px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:700; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; box-shadow:0 4px 15px rgba(124,58,237,0.3); }
        .btn-save:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(124,58,237,0.5); }

        /* Max warning */
        .max-warning { background:rgba(251,191,36,0.08); border:1px solid rgba(251,191,36,0.2); border-radius:12px; padding:14px 18px; font-size:13px; color:#fcd34d; display:flex; align-items:center; gap:8px; }

        /* Empty */
        .empty-box { text-align:center; padding:40px; color:rgba(255,255,255,0.3); }
        .empty-box .icon { font-size:40px; margin-bottom:10px; }
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
        <a href="{{ route('addresses.index') }}" class="nav-link active">📍 Addresses</a>
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
        <div>
            <h1>📍 My Addresses</h1>
            <p>Manage your delivery addresses</p>
        </div>
        <div class="count-info">
            <span>{{ $addresses->count() }}</span> / 5 addresses
        </div>
    </div>

    {{-- Address Grid --}}
    @if($addresses->count() > 0)
        <div class="address-grid">
            @foreach($addresses as $address)
                <div class="address-card {{ $address->is_default ? 'default' : '' }}">
                    @if($address->is_default)
                        <span class="default-badge">⭐ Default</span>
                    @endif

                    <span class="address-label-badge
                        {{ $address->label === 'Home' ? 'label-home' : ($address->label === 'Office' ? 'label-office' : 'label-other') }}">
                        {{ $address->label === 'Home' ? '🏠' : ($address->label === 'Office' ? '🏢' : '📌') }}
                        {{ $address->label }}
                    </span>

                    <div class="address-name">{{ $address->recipient_name }}</div>
                    <div class="address-phone">📞 {{ $address->phone }}</div>
                    <div class="address-text">
                        {{ $address->address_line }},<br>
                        {{ $address->city }}, {{ $address->district }}
                        @if($address->postal_code) — {{ $address->postal_code }} @endif
                    </div>

                    <div class="address-actions">
                        @if(!$address->is_default)
                            <form method="POST" action="{{ route('addresses.default', $address) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="addr-btn addr-btn-default">⭐ Set Default</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('addresses.destroy', $address) }}"
                              onsubmit="return confirm('Are you sure you want to delete this address?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="addr-btn addr-btn-delete">🗑️ Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-box">
            <div class="icon">📍</div>
            <p>No address has been added</p>
        </div>
    @endif

    {{-- Add New Address --}}
    @if($addresses->count() < 5)
        <div class="add-section">
            <div class="add-section-title">➕ Add New Address</div>
            <br>
            <form method="POST" action="{{ route('addresses.store') }}">
                @csrf

                <div class="form-grid">
                    <div>
                        <label class="field-label">Label</label>
                        <select name="label" class="field-input" required>
                            <option value="">Select type</option>
                            <option value="Home">🏠 Home</option>
                            <option value="Office">🏢 Office</option>
                            <option value="Other">📌 Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="field-label">Recipient Name</label>
                        <input type="text" name="recipient_name" class="field-input" placeholder="পাওয়ার ব্যক্তির নাম" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div>
                        <label class="field-label">Phone</label>
                        <input type="text" name="phone" class="field-input" placeholder="01XXXXXXXXX" required>
                    </div>
                    <div>
                        <label class="field-label">Postal Code</label>
                        <input type="text" name="postal_code" class="field-input" placeholder="1234 (optional)">
                    </div>
                </div>

                <div style="margin-bottom:14px;">
                    <label class="field-label">Address Line</label>
                    <input type="text" name="address_line" class="field-input" placeholder="**House number, street, area**
" required>
                </div>

                <div class="form-grid">
                    <div>
                        <label class="field-label">City</label>
                        <input type="text" name="city" class="field-input" placeholder="Dhaka" required>
                    </div>
                    <div>
                        <label class="field-label">District</label>
                        <input type="text" name="district" class="field-input" placeholder="Dhaka" required>
                    </div>
                </div>

                <div class="checkbox-row">
                    <input type="checkbox" name="is_default" value="1" id="is_default">
                    <label for="is_default">Set this as the default address</label>
                </div>

                <button type="submit" class="btn-save">💾 Save Address</button>
            </form>
        </div>
    @else
        <div class="max-warning">
            ⚠️ You can save a maximum of 5 addresses. Delete one to add a new address.
        </div>
    @endif

</div>
</body>
</html>