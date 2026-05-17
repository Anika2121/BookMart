<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
    <title>Login - BookMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        html, body { height:100%; overflow:hidden; }
        body { font-family:'Inter',sans-serif; display:flex; background:#09090f; color:#fff; }

        .page { display:flex; width:100%; height:100vh; }

        /* LEFT */
        .left { width:42%; flex-shrink:0; background:#09090f; position:relative; overflow:hidden; display:flex; flex-direction:column; padding:48px; }
        .left-bg { position:absolute; inset:0; background:radial-gradient(ellipse at 20% 0%,rgba(109,40,217,0.3) 0%,transparent 60%),radial-gradient(ellipse at 80% 100%,rgba(14,116,144,0.2) 0%,transparent 55%); pointer-events:none; }
        .grid-bg { position:absolute; inset:0; background-image:linear-gradient(rgba(255,255,255,0.025) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.025) 1px,transparent 1px); background-size:44px 44px; pointer-events:none; }

        .brand { display:flex; align-items:center; gap:12px; position:relative; z-index:2; margin-bottom:52px; }
        .brand-mark { width:40px; height:40px; border-radius:12px; background:linear-gradient(135deg,#6d28d9,#7c3aed); display:flex; align-items:center; justify-content:center; font-size:20px; box-shadow:0 0 24px rgba(109,40,217,0.4); }
        .brand-name { font-size:18px; font-weight:700; color:#fff; letter-spacing:-0.3px; }
        .brand-tag { margin-left:auto; font-size:11px; padding:4px 10px; border-radius:20px; background:rgba(52,211,153,0.1); color:#34d399; border:0.5px solid rgba(52,211,153,0.25); display:flex; align-items:center; gap:5px; }
        .live-dot { width:6px; height:6px; border-radius:50%; background:#34d399; animation:blink 1.5s infinite; }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.2} }

        .hero { position:relative; z-index:2; margin-bottom:36px; }
        .hero h1 { font-size:36px; font-weight:700; color:#fff; line-height:1.2; letter-spacing:-1px; margin-bottom:14px; }
        .hero h1 em { font-style:normal; background:linear-gradient(135deg,#a78bfa,#67e8f9); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .hero p { font-size:14px; color:rgba(255,255,255,0.38); line-height:1.7; max-width:340px; }

        .shelf-wrap { position:relative; z-index:2; margin-bottom:28px; }
        .shelf-row { display:flex; gap:5px; align-items:flex-end; padding:0 4px; }
        .bk { border-radius:3px 5px 5px 3px; cursor:default; transition:transform 0.25s cubic-bezier(.34,1.56,.64,1); position:relative; }
        .bk:hover { transform:translateY(-16px); z-index:10; }
        .bk::after { content:''; position:absolute; right:0; top:0; bottom:0; width:4px; background:rgba(0,0,0,0.25); border-radius:0 5px 5px 0; }
        .bk span { writing-mode:vertical-rl; font-size:8px; color:rgba(255,255,255,0.5); padding:10px 5px; display:block; letter-spacing:0.3px; white-space:nowrap; overflow:hidden; }
        .shelf-line { height:2px; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.08),transparent); border-radius:2px; margin-top:4px; }

        .quote-wrap { position:relative; z-index:2; background:rgba(255,255,255,0.03); border:0.5px solid rgba(255,255,255,0.08); border-radius:14px; padding:18px 20px; margin-bottom:24px; }
        .quote-icon { font-size:22px; color:rgba(124,58,237,0.4); line-height:1; margin-bottom:8px; font-family:Georgia,serif; }
        .quote-text { font-size:13px; color:rgba(255,255,255,0.5); line-height:1.7; font-style:italic; }
        .quote-author { font-size:12px; color:#a78bfa; margin-top:10px; font-weight:500; }
        .quote-dots { display:flex; gap:5px; margin-top:10px; }
        .qdot { width:6px; height:6px; border-radius:50%; background:rgba(255,255,255,0.12); cursor:pointer; transition:background 0.2s; }
        .qdot.active { background:#7c3aed; }

        .activity { position:relative; z-index:2; margin-top:auto; display:flex; flex-direction:column; gap:10px; }
        .act { display:flex; align-items:center; gap:10px; }
        .act-av { width:32px; height:32px; border-radius:50%; font-size:11px; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .act-info { flex:1; }
        .act-main { font-size:12px; color:rgba(255,255,255,0.55); }
        .act-main b { color:rgba(255,255,255,0.85); font-weight:600; }
        .act-time { font-size:11px; color:rgba(255,255,255,0.22); margin-top:2px; }
        .act-price { font-size:12px; color:#a78bfa; font-weight:600; flex-shrink:0; }

        /* RIGHT */
        .right { flex:1; background:#0b0b16; display:flex; align-items:center; justify-content:center; padding:48px; border-left:0.5px solid rgba(255,255,255,0.05); overflow-y:auto; }
        .right::-webkit-scrollbar { width:4px; }
        .right::-webkit-scrollbar-thumb { background:rgba(124,58,237,0.3); border-radius:4px; }

        .form { width:100%; max-width:380px; }

        .form-head { margin-bottom:28px; }
        .form-head h2 { font-size:26px; font-weight:700; color:#fff; letter-spacing:-0.5px; margin-bottom:6px; }
        .form-head p { font-size:14px; color:rgba(255,255,255,0.32); }

        .role-seg { display:flex; background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.08); border-radius:12px; padding:4px; gap:4px; margin-bottom:20px; }
        .rseg { flex:1; display:flex; align-items:center; justify-content:center; gap:6px; padding:11px 8px; border-radius:9px; cursor:pointer; transition:all 0.2s; border:1px solid transparent; }
        .rseg.active { background:rgba(109,40,217,0.22); border-color:rgba(124,58,237,0.45); }
        .rseg-icon { font-size:15px; }
        .rseg-label { font-size:13px; font-weight:500; color:rgba(255,255,255,0.3); }
        .rseg.active .rseg-label { color:#c4b5fd; }
        .rseg-admin.active { background:rgba(251,191,36,0.15); border-color:rgba(251,191,36,0.4); }
        .rseg-admin.active .rseg-label { color:#fcd34d; }

        .signing-as { font-size:11px; color:rgba(255,255,255,0.22); text-align:center; margin-bottom:18px; text-transform:uppercase; letter-spacing:1px; }

        .alert-status { background:rgba(96,165,250,0.1); border:1px solid rgba(96,165,250,0.2); color:#93c5fd; padding:12px 16px; border-radius:12px; margin-bottom:18px; font-size:13px; }

        .field { margin-bottom:14px; }
        .field label { display:block; font-size:11px; color:rgba(255,255,255,0.32); margin-bottom:7px; text-transform:uppercase; letter-spacing:0.6px; font-weight:600; }
        .input-g { position:relative; }
        .input-g i { position:absolute; left:14px; top:50%; transform:translateY(-50%); font-size:15px; pointer-events:none; opacity:0.35; font-style:normal; }
        .input-g input { width:100%; padding:13px 14px 13px 42px; background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.1); border-radius:11px; color:#fff; font-size:14px; font-family:'Inter',sans-serif; outline:none; transition:all 0.25s; }
        .input-g input:focus { border-color:rgba(124,58,237,0.6); background:rgba(124,58,237,0.06); box-shadow:0 0 0 3px rgba(124,58,237,0.12); }
        .input-g input::placeholder { color:rgba(255,255,255,0.18); }
        .error-msg { font-size:12px; color:#f87171; margin-top:5px; display:flex; align-items:center; gap:4px; }

        .row-apart { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; margin-top:6px; }
        .row-apart label { display:flex; align-items:center; gap:8px; font-size:13px; color:rgba(255,255,255,0.35); cursor:pointer; }
        .row-apart a { font-size:13px; color:#7c3aed; text-decoration:none; font-weight:500; }
        .row-apart a:hover { color:#a78bfa; }

        .btn-main { width:100%; padding:14px; background:linear-gradient(135deg,#5b21b6,#7c3aed); border:none; border-radius:12px; color:#fff; font-size:15px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.25s; letter-spacing:-0.1px; position:relative; overflow:hidden; }
        .btn-main::after { content:''; position:absolute; inset:0; background:linear-gradient(135deg,transparent,rgba(255,255,255,0.08),transparent); opacity:0; transition:opacity 0.3s; }
        .btn-main:hover::after { opacity:1; }
        .btn-main:hover { transform:translateY(-1px); box-shadow:0 10px 30px rgba(109,40,217,0.45); }
        .btn-admin { background:linear-gradient(135deg,#92400e,#d97706); }
        .btn-admin:hover { box-shadow:0 10px 30px rgba(217,119,6,0.45); }

        .ssl { display:flex; align-items:center; justify-content:center; gap:6px; margin-top:10px; font-size:12px; color:rgba(255,255,255,0.2); }

        .or-line { display:flex; align-items:center; gap:12px; margin:20px 0; }
        .or-line span { height:0.5px; flex:1; background:rgba(255,255,255,0.08); }
        .or-line p { font-size:12px; color:rgba(255,255,255,0.22); white-space:nowrap; }

        .social-btns { display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-bottom:20px; }
        .soc-btn { display:flex; align-items:center; justify-content:center; gap:8px; padding:12px; border-radius:11px; border:0.5px solid rgba(255,255,255,0.09); background:rgba(255,255,255,0.03); color:rgba(255,255,255,0.55); font-size:13px; font-weight:500; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; text-decoration:none; }
        .soc-btn:hover { background:rgba(255,255,255,0.07); border-color:rgba(255,255,255,0.18); color:#fff; }

        .reg-label { font-size:12px; color:rgba(255,255,255,0.22); text-align:center; margin-bottom:10px; }
        .reg-row { display:grid; grid-template-columns:1fr 1fr; gap:8px; }
        .reg-card { display:flex; flex-direction:column; align-items:center; gap:5px; padding:14px 10px; border-radius:12px; border:0.5px solid rgba(255,255,255,0.08); background:rgba(255,255,255,0.02); cursor:pointer; transition:all 0.2s; text-decoration:none; }
        .reg-card:hover { border-color:rgba(124,58,237,0.35); background:rgba(124,58,237,0.07); transform:translateY(-2px); }
        .reg-card-icon { font-size:20px; }
        .reg-card-title { font-size:13px; font-weight:600; color:rgba(255,255,255,0.65); }
        .reg-card-desc { font-size:11px; color:rgba(255,255,255,0.25); }

        @media(max-width:768px) {
            .left { display:none; }
            .right { padding:32px 24px; }
            .form { max-width:100%; }
        }
    </style>
</head>
<body>
<div class="page">

  <!-- LEFT -->
  <div class="left">
    <div class="left-bg"></div>
    <div class="grid-bg"></div>

    <div class="brand">
      <div class="brand-mark">📚</div>
      <span class="brand-name">BookMart</span>
      <div class="brand-tag"><span class="live-dot"></span> Live</div>
    </div>

    <div class="hero">
      <h1>Bangladesh's <em>smartest</em><br>book marketplace</h1>
      <p>Buy and sell books at unbeatable prices — from rare classics to modern bestsellers. Trusted by thousands of readers.</p>
    </div>

    <div class="shelf-wrap">
      <div class="shelf-row">
        <div class="bk" style="width:24px;height:128px;background:#1e1b4b;"><span>Atomic Habits</span></div>
        <div class="bk" style="width:20px;height:105px;background:#831843;"><span>Sapiens</span></div>
        <div class="bk" style="width:26px;height:148px;background:#78350f;"><span>Rich Dad Poor Dad</span></div>
        <div class="bk" style="width:20px;height:98px;background:#064e3b;"><span>1984</span></div>
        <div class="bk" style="width:28px;height:155px;background:#4c1d95;"><span>Clean Code</span></div>
        <div class="bk" style="width:22px;height:115px;background:#7f1d1d;"><span>Deep Work</span></div>
        <div class="bk" style="width:19px;height:120px;background:#0c4a6e;"><span>Alchemist</span></div>
        <div class="bk" style="width:24px;height:135px;background:#14532d;"><span>Think Fast Slow</span></div>
        <div class="bk" style="width:22px;height:110px;background:#312e81;"><span>Zero to One</span></div>
        <div class="bk" style="width:18px;height:95px;background:#4a044e;"><span>Dune</span></div>
      </div>
      <div class="shelf-line"></div>
    </div>

    <div class="quote-wrap">
      <div class="quote-icon">"</div>
      <div class="quote-text" id="qText">A reader lives a thousand lives before he dies. The man who never reads lives only one.</div>
      <div class="quote-author" id="qAuthor">— George R.R. Martin</div>
      <div class="quote-dots">
        <div class="qdot active" onclick="setQ(0)"></div>
        <div class="qdot" onclick="setQ(1)"></div>
        <div class="qdot" onclick="setQ(2)"></div>
      </div>
    </div>

    <div class="activity">
      <div class="act">
        <div class="act-av" style="background:rgba(124,58,237,0.2);color:#a78bfa;">RM</div>
        <div class="act-info">
          <div class="act-main"><b>Rahim</b> bought Atomic Habits</div>
          <div class="act-time">2 min ago · Dhaka</div>
        </div>
        <div class="act-price">৳320</div>
      </div>
      <div class="act">
        <div class="act-av" style="background:rgba(52,211,153,0.2);color:#34d399;">SA</div>
        <div class="act-info">
          <div class="act-main"><b>Shirin</b> listed The Alchemist</div>
          <div class="act-time">7 min ago · Chittagong</div>
        </div>
        <div class="act-price">৳280</div>
      </div>
      <div class="act">
        <div class="act-av" style="background:rgba(251,191,36,0.2);color:#fbbf24;">KH</div>
        <div class="act-info">
          <div class="act-main"><b>Karim</b> reviewed Deep Work ⭐⭐⭐⭐⭐</div>
          <div class="act-time">14 min ago · Sylhet</div>
        </div>
        <div class="act-price"></div>
      </div>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="right">
    <div class="form">
      <div class="form-head">
        <h2>Welcome back 👋</h2>
        <p>Sign in to continue to BookMart</p>
      </div>

      <div class="role-seg">
        <div class="rseg active" id="seg_buyer" onclick="setRole('buyer','Buyer',this)">
          <span class="rseg-icon">🛒</span>
          <span class="rseg-label">Buyer</span>
        </div>
        <div class="rseg" id="seg_seller" onclick="setRole('seller','Seller',this)">
          <span class="rseg-icon">📦</span>
          <span class="rseg-label">Seller</span>
        </div>
        <div class="rseg rseg-admin" id="seg_admin" onclick="setRole('admin','Admin',this)">
          <span class="rseg-icon">⚙️</span>
          <span class="rseg-label">Admin</span>
        </div>
      </div>

      <div class="signing-as" id="signingAs">Signing in as Buyer</div>

      @if(session('status'))
        <div class="alert-status">{{ session('status') }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="hidden" name="role" id="role_input" value="{{ old('role','buyer') }}">

        <div class="field">
          <label>Email Address</label>
          <div class="input-g">
            <i>✉</i>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" required autofocus autocomplete="username">
          </div>
          @error('email')<div class="error-msg">⚠️ {{ $message }}</div>@enderror
        </div>

        <div class="field">
          <label>Password</label>
          <div class="input-g">
            <i>🔑</i>
            <input type="password" name="password" placeholder="••••••••" required autocomplete="current-password">
          </div>
          @error('password')<div class="error-msg">⚠️ {{ $message }}</div>@enderror
        </div>

        <div class="row-apart">
          <label><input type="checkbox" name="remember" style="accent-color:#7c3aed;width:14px;height:14px;"> Remember me</label>
          @if(Route::has('password.request'))
            <a href="{{ route('password.request') }}">Forgot password?</a>
          @endif
        </div>

        <button type="submit" class="btn-main" id="mainBtn">Sign in as Buyer →</button>
        <div class="ssl">🔒 256-bit SSL encrypted · Your data is safe</div>
      </form>

      <div class="or-line"><span></span><p>or continue with</p><span></span></div>

      <div class="social-btns">
        <a href="{{ route('socialite.redirect','google') }}" class="soc-btn">
          <svg width="16" height="16" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
          Google
        </a>
        <a href="{{ route('socialite.redirect','facebook') }}" class="soc-btn">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          Facebook
        </a>
      </div>

      <div class="reg-label">New to BookMart? Create a free account:</div>
      <div class="reg-row">
        <a href="{{ route('register') }}" class="reg-card">
          <span class="reg-card-icon">🛒</span>
          <span class="reg-card-title">Buyer Account</span>
          <span class="reg-card-desc">Browse & buy books</span>
        </a>
        <a href="{{ route('register') }}" class="reg-card">
          <span class="reg-card-icon">📚</span>
          <span class="reg-card-title">Seller Account</span>
          <span class="reg-card-desc">List & earn money</span>
        </a>
      </div>
    </div>
  </div>
</div>

<script>
const quotes = [
  { t:"A reader lives a thousand lives before he dies. The man who never reads lives only one.", a:"— George R.R. Martin" },
  { t:"Not all those who wander are lost. A book is a dream that you hold in your hands.", a:"— Neil Gaiman" },
  { t:"There is no friend as loyal as a book. Reading gives us somewhere to go when we have to stay.", a:"— Ernest Hemingway" }
];
let qi = 0;
function setQ(i) {
  qi = i;
  document.getElementById('qText').textContent = quotes[i].t;
  document.getElementById('qAuthor').textContent = quotes[i].a;
  document.querySelectorAll('.qdot').forEach((d,j) => d.classList.toggle('active', j===i));
}
setInterval(() => setQ((qi+1) % quotes.length), 4000);

function setRole(role, label, el) {
  document.getElementById('role_input').value = role;
  document.querySelectorAll('.rseg').forEach(r => r.classList.remove('active'));
  el.classList.add('active');
  document.getElementById('signingAs').textContent = 'Signing in as ' + label;
  const btn = document.getElementById('mainBtn');
  btn.textContent = 'Sign in as ' + label + ' →';
  btn.className = 'btn-main' + (role === 'admin' ? ' btn-admin' : '');
}

const oldRole = "{{ old('role','buyer') }}";
if (oldRole === 'seller') setRole('seller','Seller', document.getElementById('seg_seller'));
if (oldRole === 'admin') setRole('admin','Admin', document.getElementById('seg_admin'));
</script>
</body>
</html>