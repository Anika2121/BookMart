<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>??</text></svg>">
    <title>Payment - BookMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#0a0a0f; color:#fff; min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:24px; }

        body::before { content:''; position:fixed; width:600px; height:600px; background:radial-gradient(circle,rgba(124,58,237,0.12),transparent 70%); top:-200px; left:-200px; border-radius:50%; pointer-events:none; }
        body::after { content:''; position:fixed; width:400px; height:400px; background:radial-gradient(circle,rgba(52,211,153,0.08),transparent 70%); bottom:-100px; right:-100px; border-radius:50%; pointer-events:none; }

        .payment-card { background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:24px; padding:40px; max-width:460px; width:100%; position:relative; overflow:hidden; }
        .payment-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#7c3aed,#a855f7,#ec4899,#f59e0b); }

        /* Header */
        .payment-header { text-align:center; margin-bottom:32px; }
        .payment-icon { width:72px; height:72px; border-radius:20px; background:linear-gradient(135deg,rgba(124,58,237,0.2),rgba(168,85,247,0.1)); border:1px solid rgba(124,58,237,0.3); display:flex; align-items:center; justify-content:center; font-size:32px; margin:0 auto 16px; }
        .payment-title { font-size:22px; font-weight:800; margin-bottom:6px; }
        .payment-subtitle { font-size:13px; color:rgba(255,255,255,0.4); }

        /* Sandbox Badge */
        .sandbox-badge { display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700; background:rgba(251,191,36,0.1); border:1px solid rgba(251,191,36,0.2); color:#fcd34d; margin-top:8px; }

        /* Order Info */
        .order-info { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:14px; padding:18px; margin-bottom:24px; }
        .order-info-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
        .order-info-row:last-child { margin-bottom:0; }
        .order-info-label { font-size:12px; color:rgba(255,255,255,0.4); font-weight:500; }
        .order-info-value { font-size:13px; font-weight:700; color:#fff; text-align:right; max-width:220px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .order-info-amount { font-size:22px; font-weight:900; background:linear-gradient(135deg,#a78bfa,#f472b6); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .txn-id { font-size:11px; color:rgba(255,255,255,0.3); font-family:monospace; }

        /* Payment Methods */
        .payment-methods { margin-bottom:24px; }
        .methods-title { font-size:12px; font-weight:600; color:rgba(255,255,255,0.4); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:12px; }
        .method-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
        .method-btn { padding:14px 12px; border-radius:12px; border:2px solid rgba(255,255,255,0.08); background:rgba(255,255,255,0.03); cursor:pointer; transition:all 0.2s; display:flex; flex-direction:column; align-items:center; gap:6px; }
        .method-btn:hover { border-color:rgba(124,58,237,0.4); background:rgba(124,58,237,0.06); }
        .method-btn.selected { border-color:rgba(124,58,237,0.6); background:rgba(124,58,237,0.1); }
        .method-icon { font-size:24px; }
        .method-name { font-size:12px; font-weight:700; color:#fff; }
        .method-desc { font-size:10px; color:rgba(255,255,255,0.35); }

        /* Confirm Button */
        .btn-confirm { width:100%; padding:16px; background:linear-gradient(135deg,#059669,#10b981); color:#fff; border:none; border-radius:14px; font-size:16px; font-weight:800; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.3s; box-shadow:0 6px 25px rgba(16,185,129,0.3); margin-bottom:10px; }
        .btn-confirm:hover { transform:translateY(-2px); box-shadow:0 10px 35px rgba(16,185,129,0.5); }
        .btn-cancel { width:100%; padding:12px; background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.15); color:#f87171; border-radius:12px; font-size:14px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; text-decoration:none; text-align:center; display:block; transition:all 0.2s; }
        .btn-cancel:hover { background:rgba(239,68,68,0.15); }

        /* Security */
        .security-row { display:flex; justify-content:center; align-items:center; gap:16px; margin-top:16px; flex-wrap:wrap; }
        .security-item { display:flex; align-items:center; gap:5px; font-size:11px; color:rgba(255,255,255,0.25); }

        /* Timer */
        .timer { text-align:center; margin-bottom:16px; font-size:13px; color:rgba(255,255,255,0.4); }
        .timer span { color:#fcd34d; font-weight:700; font-size:15px; }

        /* Divider */
        .divider { display:flex; align-items:center; gap:10px; margin:16px 0; }
        .divider-line { flex:1; height:1px; background:rgba(255,255,255,0.06); }
        .divider-text { font-size:11px; color:rgba(255,255,255,0.2); }
    </style>
</head>
<body>

<div class="payment-card">

    {{-- Header --}}
    <div class="payment-header">
        <div class="payment-icon">💳</div>
        <div class="payment-title">Complete Payment</div>
        <div class="payment-subtitle">Secure checkout powered by BookMart</div>
        <div class="sandbox-badge">⚠️ Sandbox Mode — Test Payment</div>
    </div>

    {{-- Order Info --}}
    <div class="order-info">
        <div class="order-info-row">
            <span class="order-info-label">Book</span>
            <span class="order-info-value">{{ $order->book->title }}</span>
        </div>
        <div class="order-info-row">
            <span class="order-info-label">Author</span>
            <span class="order-info-value" style="color:rgba(255,255,255,0.6);">{{ $order->book->author }}</span>
        </div>
        <div class="order-info-row">
            <span class="order-info-label">Order ID</span>
            <span class="order-info-value" style="color:rgba(255,255,255,0.6);">#{{ $order->id }}</span>
        </div>
        <div class="order-info-row" style="margin-top:12px; padding-top:12px; border-top:1px solid rgba(255,255,255,0.06);">
            <span class="order-info-label">Total Amount</span>
            <span class="order-info-amount">৳{{ number_format($order->price, 0) }}</span>
        </div>
        <div style="margin-top:8px;">
            <div class="order-info-label">Transaction ID</div>
            <div class="txn-id">{{ $txnId }}</div>
        </div>
    </div>

    {{-- Payment Methods --}}
    <div class="payment-methods">
        <div class="methods-title">Select Payment Method</div>
        <div class="method-grid">
            <div class="method-btn selected" onclick="selectMethod(this)">
                <span class="method-icon">💳</span>
                <span class="method-name">Card</span>
                <span class="method-desc">Visa / Mastercard</span>
            </div>
            <div class="method-btn" onclick="selectMethod(this)">
                <span class="method-icon">📱</span>
                <span class="method-name">bKash</span>
                <span class="method-desc">Mobile Banking</span>
            </div>
            <div class="method-btn" onclick="selectMethod(this)">
                <span class="method-icon">🏦</span>
                <span class="method-name">Nagad</span>
                <span class="method-desc">Mobile Banking</span>
            </div>
            <div class="method-btn" onclick="selectMethod(this)">
                <span class="method-icon">💵</span>
                <span class="method-name">Cash on Delivery</span>
                <span class="method-desc">Pay on arrival</span>
            </div>
        </div>
    </div>

    {{-- Timer --}}
    <div class="timer">
        Session expires in <span id="timer">10:00</span>
    </div>

    {{-- Confirm --}}
    <form method="POST" action="{{ route('payment.mock.confirm') }}">
        @csrf
        <input type="hidden" name="tran_id" value="{{ $txnId }}">
        <button type="submit" class="btn-confirm">
            ✅ Confirm Payment — ৳{{ number_format($order->price, 0) }}
        </button>
    </form>

    <a href="{{ route('orders.my') }}" class="btn-cancel">✕ Cancel & Go Back</a>

    {{-- Security --}}
    <div class="security-row">
        <div class="security-item">🔒 SSL Encrypted</div>
        <div class="security-item">🛡️ PCI DSS</div>
        <div class="security-item">✅ 100% Secure</div>
    </div>

</div>

<script>
function selectMethod(el) {
    document.querySelectorAll('.method-btn').forEach(b => b.classList.remove('selected'));
    el.classList.add('selected');
}

// Countdown timer
let seconds = 600;
const timerEl = document.getElementById('timer');
const interval = setInterval(() => {
    seconds--;
    if (seconds <= 0) {
        clearInterval(interval);
        timerEl.textContent = '00:00';
        timerEl.style.color = '#f87171';
        return;
    }
    const m = Math.floor(seconds / 60).toString().padStart(2, '0');
    const s = (seconds % 60).toString().padStart(2, '0');
    timerEl.textContent = m + ':' + s;
    if (seconds <= 60) timerEl.style.color = '#f87171';
}, 1000);
</script>

</body>
</html>