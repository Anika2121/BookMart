<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
    <title>Add New Book — BookMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        :root {
            --bg:#080a0f; --surface:#0d1117; --surface-2:#161b22; --surface-3:#1c2128;
            --border:rgba(255,255,255,0.08); --border-hover:rgba(255,255,255,0.16);
            --text-primary:#f0f6fc; --text-secondary:#8b949e; --text-muted:#484f58;
            --accent:#7c3aed; --accent-2:#a855f7; --accent-glow:rgba(124,58,237,0.25);
            --green:#3fb950; --red:#f85149;
        }
        body { font-family:'Inter',sans-serif; background:var(--bg); color:var(--text-primary); min-height:100vh; }

        nav { position:sticky; top:0; z-index:100; background:rgba(8,10,15,0.9); backdrop-filter:blur(24px); border-bottom:1px solid var(--border); padding:0 32px; height:60px; display:flex; align-items:center; justify-content:space-between; }
        .nav-left { display:flex; align-items:center; gap:8px; }
        .nav-logo-icon { width:28px; height:28px; border-radius:8px; background:linear-gradient(135deg,var(--accent),var(--accent-2)); display:flex; align-items:center; justify-content:center; font-size:14px; }
        .nav-logo-text { font-size:15px; font-weight:700; }
        .nav-right { display:flex; align-items:center; gap:8px; }
        .nav-link { padding:6px 12px; border-radius:6px; color:var(--text-secondary); font-size:13px; text-decoration:none; transition:all 0.15s; }
        .nav-link:hover { color:var(--text-primary); background:var(--surface-2); }
        .nav-btn { padding:6px 14px; border-radius:6px; background:var(--surface-2); border:1px solid var(--border); color:var(--text-primary); font-size:13px; font-weight:500; cursor:pointer; transition:all 0.15s; font-family:inherit; }
        .nav-btn:hover { border-color:var(--border-hover); }

        .page-wrap { display:grid; grid-template-columns:1fr 380px; gap:0; max-width:1200px; margin:0 auto; padding:40px 24px; }
        @media(max-width:900px) { .page-wrap { grid-template-columns:1fr; } .preview-side { display:none; } }

        .form-side { padding-right:48px; }
        .breadcrumb { display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-muted); margin-bottom:28px; }
        .breadcrumb a { color:var(--text-muted); text-decoration:none; }
        .breadcrumb a:hover { color:var(--text-secondary); }
        .page-title { font-size:24px; font-weight:800; letter-spacing:-0.5px; margin-bottom:6px; }
        .page-sub { font-size:13px; color:var(--text-secondary); margin-bottom:36px; }

        .section { margin-bottom:32px; }
        .section-header { display:flex; align-items:center; gap:10px; margin-bottom:18px; padding-bottom:12px; border-bottom:1px solid var(--border); }
        .section-num { width:22px; height:22px; border-radius:50%; background:var(--accent); color:#fff; font-size:11px; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .section-title { font-size:13px; font-weight:600; }
        .section-sub { font-size:12px; color:var(--text-muted); margin-left:auto; }

        .field { margin-bottom:16px; }
        .field-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        label { display:block; font-size:12px; font-weight:500; color:var(--text-secondary); margin-bottom:7px; }
        label .req { color:var(--red); margin-left:2px; }

        input[type="text"], input[type="number"], select, textarea { width:100%; padding:10px 12px; background:var(--surface-2); border:1px solid var(--border); border-radius:8px; color:var(--text-primary); font-size:14px; font-family:inherit; outline:none; transition:all 0.15s; }
        input:focus, select:focus, textarea:focus { border-color:var(--accent); box-shadow:0 0 0 3px var(--accent-glow); background:var(--surface-3); }
        input::placeholder, textarea::placeholder { color:var(--text-muted); font-size:13px; }
        select option { background:var(--surface-2); }
        textarea { resize:vertical; min-height:90px; line-height:1.6; }
        .error-msg { font-size:12px; color:var(--red); margin-top:5px; }

        .input-prefix-wrap { position:relative; }
        .input-prefix { position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:14px; font-weight:600; color:var(--text-muted); pointer-events:none; }
        .input-prefix-wrap input { padding-left:26px; }

        .char-count { font-size:11px; color:var(--text-muted); text-align:right; margin-top:4px; }

        .condition-pills { display:flex; gap:8px; flex-wrap:wrap; }
        .condition-pill input[type="radio"] { display:none; }
        .condition-pill label { padding:7px 16px; border-radius:20px; border:1px solid var(--border); background:var(--surface-2); font-size:12px; font-weight:600; color:var(--text-secondary); cursor:pointer; transition:all 0.15s; margin:0; }
        .condition-pill input:checked + label { border-color:var(--accent); background:rgba(124,58,237,0.15); color:#a78bfa; }

        .upload-zone { border:1.5px dashed var(--border); border-radius:12px; padding:28px; text-align:center; cursor:pointer; transition:all 0.2s; position:relative; background:var(--surface-2); }
        .upload-zone:hover { border-color:var(--accent); background:rgba(124,58,237,0.04); }
        .upload-zone input { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
        .upload-icon { font-size:32px; margin-bottom:10px; }
        .upload-title { font-size:13px; font-weight:600; margin-bottom:4px; }
        .upload-sub { font-size:12px; color:var(--text-muted); }
        .upload-sub strong { color:var(--accent-2); }
        #imgPreviewThumb { width:100%; max-height:180px; object-fit:cover; border-radius:8px; margin-top:14px; display:none; border:1px solid var(--border); }

        .submit-section { margin-top:36px; padding-top:24px; border-top:1px solid var(--border); display:flex; gap:12px; }
        .submit-btn { flex:1; padding:13px; background:linear-gradient(135deg,#6d28d9,#7c3aed,#9333ea); border:none; border-radius:10px; color:#fff; font-size:15px; font-weight:700; cursor:pointer; transition:all 0.2s; font-family:inherit; box-shadow:0 0 0 1px rgba(124,58,237,0.5); }
        .submit-btn:hover { transform:translateY(-1px); box-shadow:0 4px 20px rgba(124,58,237,0.5); }
        .cancel-btn { padding:13px 24px; background:var(--surface-2); border:1px solid var(--border); border-radius:10px; color:var(--text-secondary); font-size:14px; font-weight:600; cursor:pointer; font-family:inherit; text-decoration:none; display:flex; align-items:center; transition:all 0.2s; }
        .cancel-btn:hover { border-color:var(--border-hover); color:var(--text-primary); }

        /* PREVIEW */
        .preview-side { position:sticky; top:80px; height:fit-content; }
        .preview-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
        .preview-label { font-size:12px; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; }
        .preview-live { display:flex; align-items:center; gap:5px; font-size:11px; color:var(--green); font-weight:600; }
        .live-dot { width:6px; height:6px; border-radius:50%; background:var(--green); animation:livePulse 1.5s infinite; }
        @keyframes livePulse { 0%,100%{opacity:1} 50%{opacity:0.3} }

        .buyer-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
        .card-img { aspect-ratio:4/3; background:var(--surface-2); display:flex; align-items:center; justify-content:center; font-size:56px; position:relative; overflow:hidden; }
        .card-img img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; display:none; }
        .card-condition-badge { position:absolute; top:10px; right:10px; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:700; backdrop-filter:blur(8px); }
        .card-body { padding:16px; }
        .card-title-preview { font-size:15px; font-weight:700; color:var(--text-primary); margin-bottom:4px; min-height:22px; }
        .card-author-preview { font-size:12px; color:var(--text-secondary); margin-bottom:10px; }
        .card-meta { display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; }
        .card-category-preview { font-size:11px; color:var(--text-muted); background:var(--surface-2); border:1px solid var(--border); padding:3px 9px; border-radius:6px; }
        .card-price-preview { font-size:20px; font-weight:800; color:#a78bfa; }
        .card-desc-preview { font-size:12px; color:var(--text-secondary); line-height:1.6; border-top:1px solid var(--border); padding-top:12px; min-height:40px; }

        .alert-success { background:rgba(63,185,80,0.1); border:1px solid rgba(63,185,80,0.2); color:#3fb950; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:13px; }
    </style>
</head>
<body>

<nav>
    <div class="nav-left">
        <div class="nav-logo-icon">📚</div>
        <span class="nav-logo-text">BookMart</span>
    </div>
    <div class="nav-right">
        <a href="{{ route('seller.dashboard') }}" class="nav-link">Dashboard</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button class="nav-btn">Sign out</button>
        </form>
    </div>
</nav>

<div class="page-wrap">
    <div class="form-side">

        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a> ›
            <a href="{{ route('seller.dashboard') }}">Dashboard</a> ›
            <span style="color:var(--text-secondary);">New Listing</span>
        </div>

        <div class="page-title">📝 Create a new listing</div>
        <div class="page-sub">Fill in details — your preview updates live on the right →</div>

        @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data" id="bookForm">
            @csrf

            {{-- Section 1 --}}
            <div class="section">
                <div class="section-header">
                    <div class="section-num">1</div>
                    <div class="section-title">Book details</div>
                    <div class="section-sub">Required</div>
                </div>
                <div class="field">
                    <label>Title <span class="req">*</span></label>
                    <input type="text" name="title" id="f-title" value="{{ old('title') }}" placeholder="e.g. The Pragmatic Programmer" required>
                    @error('title')<div class="error-msg">⚠️ {{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label>Author <span class="req">*</span></label>
                    <input type="text" name="author" id="f-author" value="{{ old('author') }}" placeholder="e.g. Andrew Hunt" required>
                    @error('author')<div class="error-msg">⚠️ {{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label>Description <span style="color:var(--text-muted);font-weight:400;">(optional)</span></label>
                    <textarea name="description" id="f-desc" placeholder="Describe the book — edition, condition notes, highlights..." maxlength="500">{{ old('description') }}</textarea>
                    <div class="char-count"><span id="descCount">0</span>/500 characters</div>
                    @error('description')<div class="error-msg">⚠️ {{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Section 2 --}}
            <div class="section">
                <div class="section-header">
                    <div class="section-num">2</div>
                    <div class="section-title">Pricing & category</div>
                </div>
                <div class="field-row">
                    <div class="field">
                        <label>Price (BDT) <span class="req">*</span></label>
                        <div class="input-prefix-wrap">
                            <span class="input-prefix">৳</span>
                            <input type="number" name="price" id="f-price" value="{{ old('price') }}" min="0" step="1" placeholder="0" required>
                        </div>
                        @error('price')<div class="error-msg">⚠️ {{ $message }}</div>@enderror
                    </div>
                    <div class="field">
                        <label>Category <span class="req">*</span></label>
                        <select name="category_id" id="f-category" required>
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="error-msg">⚠️ {{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="field">
                    <label>Condition <span class="req">*</span></label>
                    <div class="condition-pills">
                        @foreach(['New', 'Like New', 'Good', 'Fair', 'Poor'] as $cond)
                        <div class="condition-pill">
                            <input type="radio" name="condition" id="cond{{ $loop->index }}" value="{{ $cond }}"
                                {{ old('condition','New') === $cond ? 'checked' : '' }}>
                            <label for="cond{{ $loop->index }}">{{ $cond }}</label>
                        </div>
                        @endforeach
                    </div>
                    @error('condition')<div class="error-msg">⚠️ {{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Section 3 --}}
            <div class="section">
                <div class="section-header">
                    <div class="section-num">3</div>
                    <div class="section-title">Cover image</div>
                    <div class="section-sub">Strongly recommended</div>
                </div>
                <div class="upload-zone" id="uploadZone">
                    <input type="file" name="image" id="f-image" accept="image/*">
                    <div class="upload-icon">📷</div>
                    <div class="upload-title">Drop your cover image here</div>
                    <div class="upload-sub">or click to browse — <strong>PNG, JPG up to 2MB</strong></div>
                    <img id="imgPreviewThumb" src="" alt="Preview">
                </div>
                @error('image')<div class="error-msg">⚠️ {{ $message }}</div>@enderror
            </div>

            <div class="submit-section">
                <a href="{{ route('seller.dashboard') }}" class="cancel-btn">← Cancel</a>
                <button type="submit" class="submit-btn">🚀 Publish listing</button>
            </div>
        </form>
    </div>

    {{-- LIVE PREVIEW --}}
    <div class="preview-side">
        <div class="preview-header">
            <span class="preview-label">Buyer's view</span>
            <span class="preview-live"><span class="live-dot"></span> Live preview</span>
        </div>
        <div class="buyer-card">
            <div class="card-img" id="cardImgWrap">
                <img id="cardImgPreview" src="" alt="">
                <span id="cardImgPlaceholder">📖</span>
                <span class="card-condition-badge" id="condBadge" style="background:rgba(63,185,80,0.2);color:#3fb950;">New</span>
            </div>
            <div class="card-body">
                <div class="card-title-preview" id="prev-title">Book title will appear here</div>
                <div class="card-author-preview" id="prev-author">Author name</div>
                <div class="card-meta">
                    <span class="card-category-preview" id="prev-category">Category</span>
                    <span class="card-price-preview" id="prev-price">৳ —</span>
                </div>
                <div class="card-desc-preview" id="prev-desc">Description will appear here once you start typing...</div>
            </div>
        </div>

        <div style="margin-top:16px;padding:14px;background:rgba(124,58,237,0.06);border:1px solid rgba(124,58,237,0.15);border-radius:12px;">
            <div style="font-size:11px;font-weight:700;color:#a78bfa;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.5px;">📢 Listing Tips</div>
            <div style="font-size:12px;color:rgba(255,255,255,0.45);line-height:1.7;">
                ✅ Add a clear cover photo<br>
                ✅ Set a competitive price<br>
                ✅ Describe condition honestly<br>
                ✅ Include edition & publisher
            </div>
        </div>
    </div>
</div>

<script>
// Title
document.getElementById('f-title').addEventListener('input', function() {
    document.getElementById('prev-title').textContent = this.value || 'Book title will appear here';
});

// Author
document.getElementById('f-author').addEventListener('input', function() {
    document.getElementById('prev-author').textContent = this.value || 'Author name';
});

// Description
document.getElementById('f-desc').addEventListener('input', function() {
    document.getElementById('prev-desc').textContent = this.value || 'Description will appear here once you start typing...';
    document.getElementById('descCount').textContent = this.value.length;
});

// Price
document.getElementById('f-price').addEventListener('input', function() {
    document.getElementById('prev-price').textContent = this.value ? '৳' + parseInt(this.value).toLocaleString() : '৳ —';
});

// Category
document.getElementById('f-category').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    document.getElementById('prev-category').textContent = opt.value ? opt.text : 'Category';
});

// Condition
document.querySelectorAll('input[name="condition"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        const badge = document.getElementById('condBadge');
        badge.textContent = this.value;
        const colors = {
            'New':      'background:rgba(63,185,80,0.2);color:#3fb950;',
            'Like New': 'background:rgba(96,165,250,0.2);color:#60a5fa;',
            'Good':     'background:rgba(251,191,36,0.2);color:#fbbf24;',
            'Fair':     'background:rgba(251,146,60,0.2);color:#fb923c;',
            'Poor':     'background:rgba(248,113,113,0.2);color:#f87171;',
        };
        badge.style.cssText = colors[this.value] || colors['New'];
    });
});

// Image
document.getElementById('f-image').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById('cardImgPreview');
        const placeholder = document.getElementById('cardImgPlaceholder');
        const thumb = document.getElementById('imgPreviewThumb');
        img.src = e.target.result;
        img.style.display = 'block';
        placeholder.style.display = 'none';
        thumb.src = e.target.result;
        thumb.style.display = 'block';
    };
    reader.readAsDataURL(file);
});

// Init desc count
document.getElementById('descCount').textContent = document.getElementById('f-desc').value.length;
</script>
</body>
</html>