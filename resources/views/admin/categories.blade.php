<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
    <title>Manage Categories - BookMart Admin</title>
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
        .topbar { margin-bottom:24px; }
        .topbar h1 { font-size:22px; font-weight:700; color:#fff; letter-spacing:-0.4px; }
        .topbar p { font-size:13px; color:rgba(255,255,255,0.35); margin-top:3px; }

        .alert { padding:12px 18px; border-radius:12px; margin-bottom:20px; font-size:13px; display:flex; align-items:center; gap:8px; }
        .alert-success { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#6ee7b7; }
        .alert-error { background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#fca5a5; }

        .grid-2 { display:grid; grid-template-columns:320px 1fr; gap:24px; }
        @media(max-width:900px) { .grid-2 { grid-template-columns:1fr; } }

        .card { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.08); border-radius:16px; overflow:hidden; }
        .card-header { padding:18px 22px; border-bottom:0.5px solid rgba(255,255,255,0.06); display:flex; justify-content:space-between; align-items:center; }
        .card-title { font-size:14px; font-weight:700; color:#fff; }
        .card-count { font-size:12px; color:rgba(255,255,255,0.3); background:rgba(255,255,255,0.05); padding:3px 10px; border-radius:20px; }
        .card-body { padding:22px; }

        .field { margin-bottom:14px; }
        .field label { display:block; font-size:11px; font-weight:600; color:rgba(255,255,255,0.35); margin-bottom:7px; text-transform:uppercase; letter-spacing:0.6px; }
        .field input { width:100%; padding:10px 14px; background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.1); border-radius:9px; color:#fff; font-size:13px; font-family:'Inter',sans-serif; outline:none; transition:all 0.2s; }
        .field input:focus { border-color:rgba(99,102,241,0.5); background:rgba(99,102,241,0.05); box-shadow:0 0 0 3px rgba(99,102,241,0.1); }
        .field input::placeholder { color:rgba(255,255,255,0.2); }
        .field-error { font-size:11px; color:#f87171; margin-top:4px; }

        .btn-add { width:100%; padding:11px; background:linear-gradient(135deg,#6366f1,#818cf8); border:none; border-radius:10px; color:#fff; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .btn-add:hover { transform:translateY(-1px); box-shadow:0 4px 14px rgba(99,102,241,0.4); }

        /* CATEGORY GRID */
        .cat-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:12px; padding:20px; }
        .cat-card { background:rgba(255,255,255,0.03); border:0.5px solid rgba(255,255,255,0.08); border-radius:12px; padding:16px; transition:all 0.2s; position:relative; }
        .cat-card:hover { border-color:rgba(99,102,241,0.3); background:rgba(99,102,241,0.05); }
        .cat-icon { font-size:24px; margin-bottom:10px; }
        .cat-name { font-size:14px; font-weight:700; color:#fff; margin-bottom:4px; }
        .cat-slug { font-size:11px; color:rgba(255,255,255,0.3); font-family:monospace; margin-bottom:10px; }
        .cat-count { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600; background:rgba(99,102,241,0.12); color:#818cf8; border:0.5px solid rgba(99,102,241,0.25); margin-bottom:12px; }
        .cat-actions { display:flex; gap:6px; }
        .tbl-btn { padding:5px 12px; border-radius:7px; font-size:11px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; border:0.5px solid transparent; }
        .btn-edit { background:rgba(251,191,36,0.1); color:#fbbf24; border-color:rgba(251,191,36,0.25); }
        .btn-edit:hover { background:rgba(251,191,36,0.2); }
        .btn-del { background:rgba(239,68,68,0.1); color:#f87171; border-color:rgba(239,68,68,0.25); }
        .btn-del:hover { background:rgba(239,68,68,0.2); }

        .empty { padding:40px; text-align:center; color:rgba(255,255,255,0.25); }
        .empty-icon { font-size:32px; margin-bottom:8px; }

        /* MODAL */
        .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.75); z-index:100; align-items:center; justify-content:center; backdrop-filter:blur(4px); }
        .modal-overlay.show { display:flex; }
        .modal { background:#0f0f1e; border:0.5px solid rgba(255,255,255,0.1); border-radius:16px; padding:28px; width:420px; max-width:90vw; }
        .modal-title { font-size:16px; font-weight:700; color:#fff; margin-bottom:20px; }
        .modal-actions { display:flex; gap:10px; margin-top:20px; }
        .btn-save { flex:1; padding:11px; background:linear-gradient(135deg,#6366f1,#818cf8); border:none; border-radius:10px; color:#fff; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .btn-save:hover { transform:translateY(-1px); box-shadow:0 4px 14px rgba(99,102,241,0.4); }
        .btn-cancel { flex:1; padding:11px; background:rgba(255,255,255,0.05); border:0.5px solid rgba(255,255,255,0.1); border-radius:10px; color:rgba(255,255,255,0.6); font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .btn-cancel:hover { background:rgba(255,255,255,0.1); color:#fff; }

        @media(max-width:768px) { .sidebar { display:none; } .main { margin-left:0; padding:20px 16px; } }
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
      <a href="{{ route('admin.orders') }}" class="sb-link">
        <span class="sb-link-icon">🛒</span> Orders
      </a>
      <a href="{{ route('admin.categories') }}" class="sb-link active">
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
      <h1>🏷️ Manage Categories</h1>
      <p>Add, edit and delete book categories</p>
    </div>

    @if(session('success'))
      <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="alert alert-error">❌ {{ $errors->first() }}</div>
    @endif

    <div class="grid-2">

      <!-- ADD FORM -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">➕ Add New Category</span>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="field">
              <label>Category Name</label>
              <input type="text" name="name" id="newName" value="{{ old('name') }}" placeholder="e.g. Science Fiction" required>
              @error('name')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
              <label>Slug <span style="color:rgba(255,255,255,0.2);font-weight:400;">(auto-generated)</span></label>
              <input type="text" name="slug" id="newSlug" value="{{ old('slug') }}" placeholder="e.g. science-fiction" required>
              @error('slug')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn-add">➕ Add Category</button>
          </form>

          <!-- TIPS -->
          <div style="margin-top:20px;padding:14px;background:rgba(99,102,241,0.06);border:0.5px solid rgba(99,102,241,0.15);border-radius:10px;">
            <div style="font-size:11px;font-weight:700;color:#818cf8;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.5px;">💡 Tips</div>
            <div style="font-size:12px;color:rgba(255,255,255,0.4);line-height:1.7;">
              ✅ Use clear, descriptive names<br>
              ✅ Slug is auto-generated<br>
              ✅ Deleting removes category from books<br>
              ✅ Keep categories broad
            </div>
          </div>
        </div>
      </div>

      <!-- CATEGORIES LIST -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">All Categories</span>
          <span class="card-count">{{ $categories->count() }} total</span>
        </div>

        @if($categories->isEmpty())
          <div class="empty">
            <div class="empty-icon">🏷️</div>
            <p>No categories yet. Add one!</p>
          </div>
        @else
          <div class="cat-grid">
            @php
              $icons = ['📚','🔬','📖','🎭','💻','🌍','💰','❤️','🧠','🎨','⚽','🎵','🌿','🏛️','✈️'];
            @endphp
            @foreach($categories as $i => $cat)
              <div class="cat-card">
                <div class="cat-icon">{{ $icons[$i % count($icons)] }}</div>
                <div class="cat-name">{{ $cat->name }}</div>
                <div class="cat-slug">{{ $cat->slug }}</div>
                <div class="cat-count">📚 {{ $cat->books->count() }} books</div>
                <div class="cat-actions">
                  <button onclick="openEdit({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ $cat->slug }}')" class="tbl-btn btn-edit">✏️ Edit</button>
                  <form method="POST" action="{{ route('admin.categories.destroy',$cat) }}" style="margin:0;" onsubmit="return confirm('Delete {{ addslashes($cat->name) }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="tbl-btn btn-del">🗑️</button>
                  </form>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </main>
</div>

<!-- EDIT MODAL -->
<div class="modal-overlay" id="editModal">
  <div class="modal">
    <div class="modal-title">✏️ Edit Category</div>
    <form method="POST" id="editForm">
      @csrf @method('PATCH')
      <div class="field">
        <label>Category Name</label>
        <input type="text" name="name" id="editName" required>
      </div>
      <div class="field">
        <label>Slug</label>
        <input type="text" name="slug" id="editSlug" required>
      </div>
      <div class="modal-actions">
        <button type="submit" class="btn-save">💾 Save Changes</button>
        <button type="button" onclick="closeEdit()" class="btn-cancel">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
// Auto slug for new category
document.getElementById('newName').addEventListener('input', function() {
    document.getElementById('newSlug').value = this.value.toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^a-z0-9-]/g, '');
});

// Auto slug for edit modal
document.getElementById('editName').addEventListener('input', function() {
    document.getElementById('editSlug').value = this.value.toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^a-z0-9-]/g, '');
});

function openEdit(id, name, slug) {
    document.getElementById('editForm').action = '/admin/categories/' + id;
    document.getElementById('editName').value = name;
    document.getElementById('editSlug').value = slug;
    document.getElementById('editModal').classList.add('show');
}

function closeEdit() {
    document.getElementById('editModal').classList.remove('show');
}

// Close modal on backdrop click
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEdit();
});
</script>
</body>
</html>