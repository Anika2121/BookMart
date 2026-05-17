<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>??</text></svg>">
    <title>Create Account — BookMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg: #080a0f;
            --surface: #0d1117;
            --surface-2: #161b22;
            --surface-3: #1c2128;
            --border: rgba(255,255,255,0.08);
            --border-hover: rgba(255,255,255,0.16);
            --text-primary: #f0f6fc;
            --text-secondary: #8b949e;
            --text-muted: #484f58;
            --accent: #7c3aed;
            --accent-2: #a855f7;
            --accent-glow: rgba(124,58,237,0.25);
            --red: #f85149;
            --green: #3fb950;
        }
        html { font-family: 'Inter', sans-serif; }
        body { background: var(--bg); min-height: 100vh; display: flex; overflow: hidden; }

        /* ── LEFT PANEL ── */
        .left-panel {
            width: 480px; flex-shrink: 0;
            background: linear-gradient(160deg, #0d1117 0%, #0f0a1e 50%, #0d1117 100%);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            padding: 36px 40px;
            position: relative; overflow: hidden;
        }

        /* Glow orbs */
        .orb1 { position: absolute; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(124,58,237,0.18), transparent 65%); top: -150px; left: -150px; pointer-events: none; animation: orbFloat 8s ease-in-out infinite; }
        .orb2 { position: absolute; width: 400px; height: 400px; border-radius: 50%; background: radial-gradient(circle, rgba(236,72,153,0.12), transparent 65%); bottom: -100px; right: -100px; pointer-events: none; animation: orbFloat 10s ease-in-out infinite reverse; }
        @keyframes orbFloat { 0%,100%{transform:translate(0,0)} 50%{transform:translate(30px,40px)} }

        .brand { display: flex; align-items: center; gap: 10px; margin-bottom: 40px; position: relative; z-index: 1; }
        .brand-icon { width: 34px; height: 34px; border-radius: 9px; background: linear-gradient(135deg, var(--accent), var(--accent-2)); display: flex; align-items: center; justify-content: center; font-size: 17px; }
        .brand-name { font-size: 17px; font-weight: 800; color: var(--text-primary); }

        /* Book shelf */
        .shelf-section { position: relative; z-index: 1; margin-bottom: 32px; }
        .shelf-title { font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 16px; }
        .book-shelf { display: flex; gap: 10px; align-items: flex-end; }
        .book-spine {
            border-radius: 4px 6px 6px 4px;
            display: flex; align-items: center; justify-content: center;
            writing-mode: vertical-rl; text-orientation: mixed;
            font-size: 9px; font-weight: 700; color: rgba(255,255,255,0.7);
            letter-spacing: 0.5px; cursor: default;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.4);
            transition: transform 0.3s;
            position: relative;
        }
        .book-spine:hover { transform: translateY(-8px); }
        .book-spine::after { content: ''; position: absolute; right: 0; top: 0; bottom: 0; width: 6px; background: rgba(0,0,0,0.2); border-radius: 0 4px 4px 0; }

        /* Floating book cards */
        .floating-cards { position: relative; z-index: 1; margin-bottom: 32px; }
        .float-card {
            background: var(--surface-2); border: 1px solid var(--border);
            border-radius: 12px; padding: 12px 14px;
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 10px; animation: fadeSlide 0.5s ease forwards;
            opacity: 0;
        }
        .float-card:nth-child(1) { animation-delay: 0.1s; }
        .float-card:nth-child(2) { animation-delay: 0.25s; }
        .float-card:nth-child(3) { animation-delay: 0.4s; }
        @keyframes fadeSlide { from{opacity:0;transform:translateX(-16px)} to{opacity:1;transform:translateX(0)} }
        .fc-cover {
            width: 38px; height: 50px; border-radius: 5px;
            flex-shrink: 0; display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .fc-info { flex: 1; min-width: 0; }
        .fc-title { font-size: 12px; font-weight: 600; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .fc-author { font-size: 11px; color: var(--text-muted); margin-top: 2px; }
        .fc-price { font-size: 13px; font-weight: 700; color: #a78bfa; flex-shrink: 0; }

        /* Live stats */
        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; position: relative; z-index: 1; margin-bottom: 32px; }
        .stat-box { background: var(--surface-2); border: 1px solid var(--border); border-radius: 10px; padding: 14px 12px; text-align: center; }
        .stat-box-val { font-size: 20px; font-weight: 800; }
        .stat-box-label { font-size: 10px; color: var(--text-muted); margin-top: 3px; text-transform: uppercase; letter-spacing: 0.5px; }

        /* Live badge */
        .live-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(63,185,80,0.1); border: 1px solid rgba(63,185,80,0.2); border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 600; color: var(--green); position: relative; z-index: 1; }
        .live-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--green); animation: livePulse 1.5s infinite; }
        @keyframes livePulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.4;transform:scale(0.8)} }

        .left-footer { position: relative; z-index: 1; margin-top: auto; }
        .left-footer p { font-size: 12px; color: var(--text-muted); }
        .left-footer a { color: var(--accent-2); text-decoration: none; font-weight: 500; }
        .left-footer a:hover { text-decoration: underline; }

        /* ── RIGHT PANEL ── */
        .right-panel { flex: 1; display: flex; align-items: center; justify-content: center; padding: 32px; overflow-y: auto; }
        .form-container { width: 100%; max-width: 400px; }

        .form-header { margin-bottom: 28px; }
        .form-header h2 { font-size: 22px; font-weight: 800; color: var(--text-primary); letter-spacing: -0.3px; margin-bottom: 6px; }
        .form-header p { font-size: 13px; color: var(--text-secondary); }

        .field { margin-bottom: 14px; }
        .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        label { display: block; font-size: 12px; font-weight: 500; color: var(--text-secondary); margin-bottom: 6px; }
        label .req { color: var(--red); margin-left: 2px; }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%; padding: 10px 13px;
            background: var(--surface-2); border: 1px solid var(--border);
            border-radius: 8px; color: var(--text-primary);
            font-size: 14px; font-family: inherit; outline: none; transition: all 0.15s;
        }
        input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-glow); background: var(--surface-3); }
        input::placeholder { color: var(--text-muted); font-size: 13px; }
        .error-msg { font-size: 12px; color: var(--red); margin-top: 4px; }

        .password-strength { height: 3px; border-radius: 2px; background: var(--surface-3); margin-top: 6px; overflow: hidden; }
        .strength-bar { height: 100%; width: 0; border-radius: 2px; transition: all 0.3s; }

        .divider { display: flex; align-items: center; gap: 12px; margin: 18px 0; }
        .divider-line { flex: 1; height: 1px; background: var(--border); }
        .divider-text { font-size: 12px; color: var(--text-muted); }

        .role-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 18px; }
        .role-option input { display: none; }
        .role-card {
            display: flex; flex-direction: column; align-items: center;
            padding: 16px 10px; border: 1px solid var(--border);
            border-radius: 12px; cursor: pointer; background: var(--surface-2);
            transition: all 0.2s; text-align: center; position: relative;
        }
        .role-card:hover { border-color: var(--border-hover); transform: translateY(-1px); }
        .role-option input:checked + .role-card { border-color: var(--accent); background: rgba(124,58,237,0.1); box-shadow: 0 0 0 1px var(--accent), 0 4px 16px rgba(124,58,237,0.2); }
        .role-check { position: absolute; top: 8px; right: 8px; width: 16px; height: 16px; border-radius: 50%; background: var(--accent); display: none; align-items: center; justify-content: center; font-size: 9px; color: #fff; font-weight: 700; }
        .role-option input:checked + .role-card .role-check { display: flex; }
        .role-icon { font-size: 26px; margin-bottom: 7px; }
        .role-title { font-size: 13px; font-weight: 700; color: var(--text-primary); margin-bottom: 2px; }
        .role-desc { font-size: 11px; color: var(--text-muted); }

        .submit-btn {
            width: 100%; padding: 12px;
            background: linear-gradient(135deg, #6d28d9, #7c3aed, #9333ea);
            border: none; border-radius: 10px; color: #fff;
            font-size: 14px; font-weight: 700; cursor: pointer;
            transition: all 0.2s; font-family: inherit;
            box-shadow: 0 1px 2px rgba(0,0,0,0.3), 0 0 0 1px rgba(124,58,237,0.5);
        }
        .submit-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(124,58,237,0.5); }
        .submit-btn:active { transform: translateY(0); }

        .login-link { text-align: center; margin-top: 18px; font-size: 13px; color: var(--text-muted); }
        .login-link a { color: var(--accent-2); text-decoration: none; font-weight: 600; }
        .login-link a:hover { text-decoration: underline; }

        @media (max-width: 900px) { .left-panel { display: none; } }
    </style>
</head>
<body>

<!-- Left Panel -->
<div class="left-panel">
    <div class="orb1"></div>
    <div class="orb2"></div>

    <div class="brand">
        <div class="brand-icon">📚</div>
        <span class="brand-name">BookMart</span>
        <div class="live-badge" style="margin-left: auto;">
            <span class="live-dot"></span> Live
        </div>
    </div>

    <!-- Book Shelf -->
    <div class="shelf-section">
        <div class="shelf-title">📚 Popular on BookMart</div>
        <div class="book-shelf">
            <div class="book-spine" style="width:32px;height:140px;background:linear-gradient(180deg,#6366f1,#4f46e5);">Atomic Habits</div>
            <div class="book-spine" style="width:28px;height:120px;background:linear-gradient(180deg,#ec4899,#be185d);">Sapiens</div>
            <div class="book-spine" style="width:30px;height:155px;background:linear-gradient(180deg,#f59e0b,#d97706);">Rich Dad</div>
            <div class="book-spine" style="width:26px;height:110px;background:linear-gradient(180deg,#10b981,#059669);">1984</div>
            <div class="book-spine" style="width:34px;height:160px;background:linear-gradient(180deg,#8b5cf6,#7c3aed);">Clean Code</div>
            <div class="book-spine" style="width:28px;height:130px;background:linear-gradient(180deg,#ef4444,#dc2626);">Think Fast</div>
            <div class="book-spine" style="width:30px;height:145px;background:linear-gradient(180deg,#06b6d4,#0891b2);">Deep Work</div>
            <div class="book-spine" style="width:26px;height:118px;background:linear-gradient(180deg,#f97316,#ea580c);">The Alchemist</div>
        </div>
        <!-- Shelf base -->
        <div style="height:4px;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.06),transparent);border-radius:2px;margin-top:4px;"></div>
    </div>

    <!-- Recent listings -->
    <div class="floating-cards">
        <div class="shelf-title">🔥 Recently Listed</div>
        <div class="float-card">
            <div class="fc-cover" style="background:linear-gradient(135deg,#6366f1,#4f46e5);">📗</div>
            <div class="fc-info">
                <div class="fc-title">The Pragmatic Programmer</div>
                <div class="fc-author">Andrew Hunt · Good condition</div>
            </div>
            <div class="fc-price">৳850</div>
        </div>
        <div class="float-card">
            <div class="fc-cover" style="background:linear-gradient(135deg,#ec4899,#be185d);">📘</div>
            <div class="fc-info">
                <div class="fc-title">Designing Data-Intensive Apps</div>
                <div class="fc-author">Martin Kleppmann · New</div>
            </div>
            <div class="fc-price">৳1,200</div>
        </div>
        <div class="float-card">
            <div class="fc-cover" style="background:linear-gradient(135deg,#f59e0b,#d97706);">📙</div>
            <div class="fc-info">
                <div class="fc-title">Zero to One</div>
                <div class="fc-author">Peter Thiel · Like New</div>
            </div>
            <div class="fc-price">৳650</div>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-box">
            <div class="stat-box-val" style="color:#a78bfa;" id="counterBooks">0</div>
            <div class="stat-box-label">Books listed</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-val" style="color:#34d399;" id="counterUsers">0</div>
            <div class="stat-box-label">Happy users</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-val" style="color:#f472b6;" id="counterSales">0</div>
            <div class="stat-box-label">Books sold</div>
        </div>
    </div>

    <div class="left-footer">
        <p>Already have an account? <a href="{{ route('login') }}">Sign in here →</a></p>
    </div>
</div>

<!-- Right Panel -->
<div class="right-panel">
    <div class="form-container">

        <div class="form-header">
            <h2>Create your account</h2>
            <p>Join BookMart — buy and sell books across Bangladesh</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="field-row">
                <div class="field">
                    <label>Full name <span class="req">*</span></label>
                    <input type="text" name="name" placeholder="Your name" value="{{ old('name') }}" required autofocus>
                    @error('name')<div class="error-msg">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label>Email address <span class="req">*</span></label>
                    <input type="email" name="email" placeholder="you@email.com" value="{{ old('email') }}" required>
                    @error('email')<div class="error-msg">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="field-row">
                <div class="field">
                    <label>Password <span class="req">*</span></label>
                    <input type="password" name="password" id="pwInput" placeholder="Min 8 characters" required>
                    <div class="password-strength"><div class="strength-bar" id="strengthBar"></div></div>
                    @error('password')<div class="error-msg">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label>Confirm password <span class="req">*</span></label>
                    <input type="password" name="password_confirmation" placeholder="Repeat password" required>
                </div>
            </div>

            <div class="divider">
                <div class="divider-line"></div>
                <div class="divider-text">I want to</div>
                <div class="divider-line"></div>
            </div>

            <div class="role-grid">
                <label class="role-option">
                    <input type="radio" name="role" value="buyer" checked>
                    <div class="role-card">
                        <div class="role-check">✓</div>
                        <div class="role-icon">🛒</div>
                        <div class="role-title">Buy Books</div>
                        <div class="role-desc">Browse & purchase</div>
                    </div>
                </label>
                <label class="role-option">
                    <input type="radio" name="role" value="seller">
                    <div class="role-card">
                        <div class="role-check">✓</div>
                        <div class="role-icon">📚</div>
                        <div class="role-title">Sell Books</div>
                        <div class="role-desc">List & earn money</div>
                    </div>
                </label>
            </div>
            @error('role')<div class="error-msg" style="margin-bottom:12px;">{{ $message }}</div>@enderror

            <button type="submit" class="submit-btn">Create account →</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>
</div>

<script>
    // Password strength
    document.getElementById('pwInput').addEventListener('input', function() {
        const val = this.value;
        const bar = document.getElementById('strengthBar');
        let s = 0;
        if (val.length >= 8) s++;
        if (/[A-Z]/.test(val)) s++;
        if (/[0-9]/.test(val)) s++;
        if (/[^A-Za-z0-9]/.test(val)) s++;
        bar.style.width = s > 0 ? ['25%','50%','75%','100%'][s-1] : '0';
        bar.style.background = s > 0 ? ['#f85149','#d29922','#3fb950','#3fb950'][s-1] : '';
    });

    // Counter animation
    function animateCounter(id, target, suffix='') {
        const el = document.getElementById(id);
        let current = 0;
        const step = Math.ceil(target / 60);
        const timer = setInterval(() => {
            current = Math.min(current + step, target);
            el.textContent = current + suffix;
            if (current >= target) clearInterval(timer);
        }, 30);
    }
    animateCounter('counterBooks', 7, '+');
    animateCounter('counterUsers', 12, '+');
    animateCounter('counterSales', 9, '+');
</script>
</body>
</html>