<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
    <title>BookMart - Buy & Sell Books Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#0a0a0f; color:#fff; overflow-x:hidden; }
        ::-webkit-scrollbar { width:6px; }
        ::-webkit-scrollbar-thumb { background:rgba(124,58,237,0.5); border-radius:3px; }

        /* MARQUEE */
        .marquee-wrapper { overflow:hidden; background:linear-gradient(90deg,#7c3aed,#4f46e5,#0ea5e9); padding:9px 0; }
        .marquee-track { display:inline-flex; animation:marquee 35s linear infinite; white-space:nowrap; }
        @keyframes marquee { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }
        .marquee-item { display:inline-flex; align-items:center; gap:8px; padding:0 28px; color:#fff; font-weight:600; font-size:12.5px; }
        .marquee-sep { color:rgba(255,255,255,0.4); }

        /* NAVBAR */
        .navbar { background:rgba(10,10,15,0.92); backdrop-filter:blur(20px); border-bottom:1px solid rgba(255,255,255,0.06); padding:14px 32px; display:flex; justify-content:space-between; align-items:center; position:sticky; top:0; z-index:100; }
        .nav-brand { display:flex; align-items:center; gap:10px; text-decoration:none; }
        .nav-brand-icon { width:34px; height:34px; border-radius:9px; background:linear-gradient(135deg,#7c3aed,#4f46e5); display:flex; align-items:center; justify-content:center; font-size:16px; }
        .nav-brand-name { font-size:17px; font-weight:900; color:#fff; }
        .nav-brand-name span { background:linear-gradient(135deg,#a78bfa,#60a5fa); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .nav-links { display:flex; align-items:center; gap:6px; }
        .nav-link { padding:7px 14px; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600; color:rgba(255,255,255,0.6); transition:all 0.2s; cursor:pointer; font-family:'Inter',sans-serif; background:transparent; border:none; }
        .nav-link:hover { background:rgba(255,255,255,0.06); color:#fff; }
        .nav-btn-primary { background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff !important; border-radius:8px; padding:8px 18px; font-size:13px; font-weight:700; text-decoration:none; transition:all 0.2s; }
        .nav-btn-primary:hover { transform:translateY(-1px); box-shadow:0 4px 16px rgba(124,58,237,0.5); }
        .nav-btn-danger { background:rgba(239,68,68,0.1); color:#f87171 !important; border:1px solid rgba(239,68,68,0.2); border-radius:8px; padding:7px 14px; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
        .nav-btn-danger:hover { background:rgba(239,68,68,0.2); }

        /* HAMBURGER */
        .hamburger { display:none; flex-direction:column; gap:5px; cursor:pointer; padding:8px; border-radius:8px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); }
        .hamburger span { width:20px; height:2px; background:#fff; border-radius:2px; transition:all 0.3s; display:block; }
        .hamburger.open span:nth-child(1) { transform:rotate(45deg) translate(5px,5px); }
        .hamburger.open span:nth-child(2) { opacity:0; }
        .hamburger.open span:nth-child(3) { transform:rotate(-45deg) translate(5px,-5px); }
        .mobile-menu { display:none; position:fixed; top:65px; left:0; right:0; background:rgba(10,10,15,0.98); backdrop-filter:blur(20px); border-bottom:1px solid rgba(255,255,255,0.08); padding:16px; z-index:99; flex-direction:column; gap:8px; }
        .mobile-menu.open { display:flex; }
        .mobile-menu-link { padding:12px 16px; border-radius:10px; text-decoration:none; font-size:14px; font-weight:600; color:rgba(255,255,255,0.7); transition:all 0.2s; display:flex; align-items:center; gap:10px; border:1px solid transparent; }
        .mobile-menu-link:hover { background:rgba(255,255,255,0.06); color:#fff; }
        .mobile-menu-link.primary { background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; }
        .mobile-menu-link.danger { background:rgba(239,68,68,0.1); color:#f87171; border-color:rgba(239,68,68,0.2); }
        .mobile-divider { height:1px; background:rgba(255,255,255,0.06); margin:4px 0; }

        /* HERO */
        .hero { min-height:90vh; display:flex; align-items:center; position:relative; overflow:hidden;
            background:radial-gradient(ellipse at 20% 50%,rgba(124,58,237,0.22) 0%,transparent 60%),
                       radial-gradient(ellipse at 80% 20%,rgba(14,165,233,0.12) 0%,transparent 60%),
                       #0a0a0f; }
        .hero-grid-bg { position:absolute; inset:0; background-image:linear-gradient(rgba(124,58,237,0.04) 1px,transparent 1px),linear-gradient(90deg,rgba(124,58,237,0.04) 1px,transparent 1px); background-size:60px 60px; }
        .orb { border-radius:50%; filter:blur(80px); position:absolute; pointer-events:none; }
        .orb-1 { width:500px; height:500px; background:rgba(124,58,237,0.13); top:-100px; left:-100px; animation:orbFloat 8s ease-in-out infinite; }
        .orb-2 { width:400px; height:400px; background:rgba(14,165,233,0.08); top:200px; right:-100px; animation:orbFloat 10s ease-in-out infinite reverse; }
        @keyframes orbFloat { 0%,100%{transform:translate(0,0)} 50%{transform:translate(25px,-25px)} }
        .hero-inner { max-width:1280px; margin:0 auto; padding:80px 32px; display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center; position:relative; z-index:1; width:100%; }
        .hero-badge { display:inline-flex; align-items:center; gap:8px; padding:5px 14px; border-radius:20px; font-size:12px; font-weight:700; background:rgba(124,58,237,0.15); border:1px solid rgba(124,58,237,0.3); color:#a78bfa; margin-bottom:22px; }
        .badge-dot { width:7px; height:7px; background:#34d399; border-radius:50%; animation:pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }
        .hero-title { font-size:64px; font-weight:900; line-height:1.06; margin-bottom:20px; }
        .hero-title .grad { background:linear-gradient(135deg,#a78bfa,#60a5fa,#34d399); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .hero-desc { font-size:15px; color:rgba(255,255,255,0.5); line-height:1.8; margin-bottom:28px; max-width:460px; }
        .hero-btns { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:28px; }
        .btn-hero-primary { padding:13px 26px; background:linear-gradient(135deg,#7c3aed,#4f46e5); color:#fff; border-radius:13px; font-size:14px; font-weight:700; text-decoration:none; border:1px solid rgba(124,58,237,0.5); transition:all 0.3s; display:inline-flex; align-items:center; gap:8px; }
        .btn-hero-primary:hover { transform:translateY(-2px); box-shadow:0 10px 32px rgba(124,58,237,0.5); }
        .btn-hero-outline { padding:13px 26px; background:transparent; color:#fff; border-radius:13px; font-size:14px; font-weight:700; text-decoration:none; border:1px solid rgba(255,255,255,0.14); transition:all 0.3s; display:inline-flex; align-items:center; gap:8px; }
        .btn-hero-outline:hover { background:rgba(255,255,255,0.05); border-color:rgba(124,58,237,0.5); transform:translateY(-2px); }
        .hero-search { display:flex; gap:10px; max-width:440px; margin-bottom:32px; }
        .hero-search-input { flex:1; padding:12px 16px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); border-radius:11px; color:#fff; font-size:14px; font-family:'Inter',sans-serif; outline:none; transition:all 0.3s; }
        .hero-search-input::placeholder { color:rgba(255,255,255,0.25); }
        .hero-search-input:focus { border-color:rgba(124,58,237,0.6); background:rgba(124,58,237,0.06); }
        .hero-search-btn { padding:12px 20px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; border:none; border-radius:11px; font-size:14px; font-weight:700; cursor:pointer; font-family:'Inter',sans-serif; white-space:nowrap; }
        .hero-stats { display:flex; gap:24px; }
        .hero-stat-num { font-size:22px; font-weight:900; }
        .hero-stat-label { font-size:11px; color:rgba(255,255,255,0.35); margin-top:2px; }
        .stat-div { width:1px; background:rgba(255,255,255,0.08); }
        .hero-right { display:grid; grid-template-columns:1fr 1fr; gap:13px; }
        .hero-book-card { background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:15px; padding:13px; text-decoration:none; transition:all 0.4s; animation:bookFloat 4s ease-in-out infinite; }
        .hero-book-card:nth-child(2) { animation-delay:.5s; }
        .hero-book-card:nth-child(3) { animation-delay:1s; }
        .hero-book-card:nth-child(4) { animation-delay:1.5s; }
        @keyframes bookFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        .hero-book-card:hover { background:rgba(255,255,255,0.08); border-color:rgba(124,58,237,0.4); transform:translateY(-8px) !important; }
        .hero-book-img { width:100%; height:155px; object-fit:cover; border-radius:9px; margin-bottom:9px; }
        .hero-book-placeholder { width:100%; height:155px; border-radius:9px; background:linear-gradient(135deg,rgba(124,58,237,0.2),rgba(14,165,233,0.1)); display:flex; align-items:center; justify-content:center; font-size:38px; margin-bottom:9px; }
        .hero-book-title { font-size:12px; font-weight:700; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .hero-book-price { font-size:14px; font-weight:800; background:linear-gradient(135deg,#a78bfa,#f472b6); -webkit-background-clip:text; -webkit-text-fill-color:transparent; margin-top:5px; }

        /* STATS BAR */
        .stats-bar { background:#070710; border-top:1px solid rgba(255,255,255,0.05); border-bottom:1px solid rgba(255,255,255,0.05); padding:44px 32px; }
        .stats-bar-inner { max-width:1000px; margin:0 auto; display:grid; grid-template-columns:repeat(4,1fr); gap:18px; }
        .sbc { background:linear-gradient(135deg,rgba(124,58,237,0.1),rgba(79,70,229,0.05)); border:1px solid rgba(124,58,237,0.15); border-radius:15px; padding:22px; text-align:center; transition:all 0.3s; }
        .sbc:hover { border-color:rgba(124,58,237,0.4); transform:translateY(-4px); }
        .sbc-icon { font-size:26px; margin-bottom:8px; }
        .sbc-num { font-size:26px; font-weight:900; margin-bottom:4px; }
        .sbc-label { font-size:12px; color:rgba(255,255,255,0.4); }

        /* SECTIONS */
        .section { padding:68px 32px; }
        .section-dark { background:#0a0a0f; }
        .section-darker { background:#070710; }
        .sw { max-width:1280px; margin:0 auto; }
        .section-head { display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:26px; }
        .section-head-center { text-align:center; margin-bottom:36px; }
        .sbadge { display:inline-flex; align-items:center; gap:6px; padding:4px 13px; border-radius:20px; font-size:11px; font-weight:700; margin-bottom:8px; }
        .sbadge-purple { background:rgba(124,58,237,0.15); border:1px solid rgba(124,58,237,0.25); color:#a78bfa; }
        .sbadge-orange { background:rgba(251,146,60,0.15); border:1px solid rgba(251,146,60,0.25); color:#fdba74; }
        .sbadge-green { background:rgba(52,211,153,0.15); border:1px solid rgba(52,211,153,0.25); color:#6ee7b7; }
        .sbadge-yellow { background:rgba(251,191,36,0.15); border:1px solid rgba(251,191,36,0.25); color:#fcd34d; }
        .sbadge-blue { background:rgba(96,165,250,0.15); border:1px solid rgba(96,165,250,0.25); color:#93c5fd; }
        .section-title { font-size:30px; font-weight:900; }
        .section-title span { background:linear-gradient(135deg,#a78bfa,#60a5fa); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .section-sub { font-size:13px; color:rgba(255,255,255,0.4); margin-top:5px; }
        .section-link { font-size:13px; color:#a78bfa; text-decoration:none; font-weight:600; }
        .section-link:hover { color:#c4b5fd; }

        /* HORIZONTAL SCROLL */
        .h-scroll { display:flex; gap:13px; overflow-x:auto; padding-bottom:8px; scrollbar-width:none; }
        .h-scroll::-webkit-scrollbar { display:none; }

        /* BOOK SM */
        .book-sm { background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:13px; overflow:hidden; flex-shrink:0; width:170px; text-decoration:none; display:block; transition:all 0.3s; position:relative; }
        .book-sm:hover { transform:translateY(-5px); border-color:rgba(124,58,237,0.35); box-shadow:0 12px 30px rgba(0,0,0,0.4); }
        .book-sm-img { width:100%; height:185px; object-fit:cover; }
        .book-sm-placeholder { width:100%; height:185px; background:linear-gradient(135deg,rgba(124,58,237,0.15),rgba(168,85,247,0.1)); display:flex; align-items:center; justify-content:center; font-size:42px; }
        .book-sm-body { padding:10px 12px; }
        .book-sm-title { font-size:13px; font-weight:700; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:2px; }
        .book-sm-author { font-size:11px; color:rgba(255,255,255,0.4); margin-bottom:6px; }
        .book-sm-footer { display:flex; justify-content:space-between; align-items:center; }
        .book-sm-price { font-size:14px; font-weight:800; background:linear-gradient(135deg,#a78bfa,#f472b6); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .book-sm-rating { font-size:11px; color:#fbbf24; }
        .rank-badge { position:absolute; top:8px; left:8px; width:22px; height:22px; border-radius:50%; background:linear-gradient(135deg,#f59e0b,#ef4444); display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:900; color:#fff; }
        .sale-badge { position:absolute; top:8px; right:8px; background:rgba(239,68,68,0.9); color:#fff; font-size:10px; font-weight:700; padding:2px 7px; border-radius:4px; }

        /* BOOK GRID LG */
        .book-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(210px,1fr)); gap:16px; }
        .book-lg { background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:15px; overflow:hidden; transition:all 0.3s; text-decoration:none; display:block; }
        .book-lg:hover { transform:translateY(-6px); border-color:rgba(124,58,237,0.35); box-shadow:0 16px 40px rgba(0,0,0,0.4); }
        .book-lg-img { width:100%; height:195px; object-fit:cover; }
        .book-lg-placeholder { width:100%; height:195px; background:linear-gradient(135deg,rgba(124,58,237,0.15),rgba(168,85,247,0.1)); display:flex; align-items:center; justify-content:center; font-size:46px; }
        .book-lg-body { padding:13px; }
        .book-lg-cat { font-size:10px; font-weight:700; color:#a78bfa; background:rgba(124,58,237,0.1); padding:2px 8px; border-radius:4px; display:inline-block; margin-bottom:6px; }
        .book-lg-title { font-size:13px; font-weight:700; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:2px; }
        .book-lg-author { font-size:11px; color:rgba(255,255,255,0.4); margin-bottom:8px; }
        .book-lg-footer { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
        .book-lg-price { font-size:15px; font-weight:800; background:linear-gradient(135deg,#a78bfa,#f472b6); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .cond-tag { font-size:10px; padding:2px 8px; border-radius:4px; font-weight:700; }
        .cond-New { background:rgba(52,211,153,0.15); color:#6ee7b7; }
        .cond-Like { background:rgba(96,165,250,0.15); color:#93c5fd; }
        .cond-Good { background:rgba(251,191,36,0.15); color:#fcd34d; }
        .cond-Fair { background:rgba(251,146,60,0.15); color:#fdba74; }
        .cond-Poor { background:rgba(239,68,68,0.15); color:#fca5a5; }
        .btn-view-book { display:block; width:100%; padding:8px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; border:none; border-radius:8px; font-size:12px; font-weight:700; text-align:center; text-decoration:none; transition:all 0.2s; }
        .btn-view-book:hover { box-shadow:0 4px 12px rgba(124,58,237,0.4); }

        /* CATEGORY */
        .cat-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(145px,1fr)); gap:11px; }
        .cat-card { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06); border-radius:15px; padding:18px 12px; text-align:center; text-decoration:none; transition:all 0.3s; display:block; }
        .cat-card:hover { border-color:rgba(124,58,237,0.4); background:rgba(124,58,237,0.06); transform:translateY(-5px); }
        .cat-icon { font-size:30px; margin-bottom:9px; display:block; }
        .cat-name { font-size:13px; font-weight:700; color:#fff; margin-bottom:3px; }
        .cat-count { font-size:11px; color:#a78bfa; font-weight:600; }

        /* FLASH SALE */
        .flash-section { background:linear-gradient(135deg,rgba(239,68,68,0.07),rgba(251,146,60,0.04)); border-top:1px solid rgba(239,68,68,0.14); border-bottom:1px solid rgba(239,68,68,0.14); padding:46px 32px; }
        .flash-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:22px; flex-wrap:wrap; gap:12px; }
        .flash-title { font-size:24px; font-weight:900; display:flex; align-items:center; gap:10px; }
        .flash-timer { display:flex; gap:7px; align-items:center; }
        .timer-block { background:rgba(239,68,68,0.15); border:1px solid rgba(239,68,68,0.25); border-radius:8px; padding:7px 11px; text-align:center; min-width:50px; }
        .timer-num { font-size:19px; font-weight:900; color:#f87171; }
        .timer-label { font-size:10px; color:rgba(255,255,255,0.4); font-weight:600; }
        .timer-sep { font-size:18px; font-weight:900; color:#f87171; }

        /* HOW IT WORKS */
        .steps-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:18px; }
        .step-card { background:linear-gradient(135deg,rgba(124,58,237,0.08),rgba(14,165,233,0.03)); border:1px solid rgba(124,58,237,0.12); border-radius:18px; padding:28px 22px; position:relative; overflow:hidden; transition:all 0.3s; }
        .step-card:hover { border-color:rgba(124,58,237,0.35); transform:translateY(-5px); }
        .step-num-bg { position:absolute; top:14px; right:18px; font-size:60px; font-weight:900; color:rgba(255,255,255,0.04); line-height:1; }
        .step-icon-wrap { width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:22px; margin-bottom:14px; }
        .step-title { font-size:17px; font-weight:800; margin-bottom:7px; }
        .step-desc { font-size:13px; color:rgba(255,255,255,0.45); line-height:1.7; }

        /* TESTIMONIALS */
        .testimonial-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; }
        .testimonial-card { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:14px; padding:20px; transition:all 0.2s; }
        .testimonial-card:hover { border-color:rgba(124,58,237,0.3); transform:translateY(-3px); }
        .tcard-stars { color:#fbbf24; font-size:14px; margin-bottom:10px; }
        .tcard-text { font-size:13px; color:rgba(255,255,255,0.6); line-height:1.7; margin-bottom:14px; font-style:italic; }
        .tcard-author { display:flex; align-items:center; gap:10px; }
        .tcard-av { width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,#7c3aed,#4f46e5); display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:800; flex-shrink:0; }
        .tcard-name { font-size:13px; font-weight:700; }
        .tcard-role { font-size:11px; color:rgba(255,255,255,0.35); }

        /* CTA */
        .cta-section { background:linear-gradient(135deg,rgba(124,58,237,0.14),rgba(79,70,229,0.09)); border-top:1px solid rgba(124,58,237,0.14); padding:76px 32px; text-align:center; }
        .cta-title { font-size:42px; font-weight:900; margin-bottom:12px; }
        .cta-title span { background:linear-gradient(135deg,#a78bfa,#60a5fa); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .cta-sub { font-size:15px; color:rgba(255,255,255,0.45); margin-bottom:30px; }
        .cta-btns { display:flex; gap:13px; justify-content:center; flex-wrap:wrap; }
        .btn-cta-primary { padding:15px 38px; background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; border-radius:13px; font-size:15px; font-weight:800; text-decoration:none; transition:all 0.3s; }
        .btn-cta-primary:hover { transform:translateY(-2px); box-shadow:0 10px 32px rgba(124,58,237,0.5); }
        .btn-cta-outline { padding:15px 38px; background:transparent; color:#fff; border-radius:13px; font-size:15px; font-weight:800; text-decoration:none; border:1px solid rgba(255,255,255,0.14); transition:all 0.3s; }
        .btn-cta-outline:hover { background:rgba(255,255,255,0.05); border-color:rgba(124,58,237,0.5); transform:translateY(-2px); }

        /* FOOTER */
        .footer { background:#070710; border-top:1px solid rgba(255,255,255,0.05); padding:52px 32px 26px; }
        .footer-inner { max-width:1200px; margin:0 auto; display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:36px; margin-bottom:36px; }
        .footer-brand-name { font-size:18px; font-weight:900; color:#fff; margin-bottom:10px; }
        .footer-brand-name span { background:linear-gradient(135deg,#a78bfa,#60a5fa); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .footer-desc { font-size:13px; color:rgba(255,255,255,0.35); line-height:1.7; }
        .footer-head { font-size:12px; font-weight:700; color:#fff; margin-bottom:12px; text-transform:uppercase; letter-spacing:0.5px; }
        .footer-links { display:flex; flex-direction:column; gap:7px; }
        .footer-link { font-size:13px; color:rgba(255,255,255,0.4); text-decoration:none; transition:color 0.2s; }
        .footer-link:hover { color:#a78bfa; }
        .footer-bottom { max-width:1200px; margin:0 auto; padding-top:22px; border-top:1px solid rgba(255,255,255,0.05); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; }
        .footer-copy { font-size:12px; color:rgba(255,255,255,0.25); }

        /* ALERT */
        .alert { padding:12px 18px; border-radius:12px; margin:16px 32px; font-size:14px; display:flex; align-items:center; gap:8px; }
        .alert-success { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#6ee7b7; }

        /* RESPONSIVE */
        @media(max-width:900px) {
            .hero-inner { grid-template-columns:1fr; padding:40px 16px; }
            .hero-right { display:none; }
            .hero-title { font-size:42px; }
            .steps-grid { grid-template-columns:1fr; }
            .testimonial-grid { grid-template-columns:1fr; }
            .stats-bar-inner { grid-template-columns:repeat(2,1fr); }
            .footer-inner { grid-template-columns:1fr 1fr; }
            .nav-links { display:none; }
            .hamburger { display:flex; }
            .section { padding:40px 16px; }
            .flash-section { padding:40px 16px; }
            .stats-bar { padding:36px 16px; }
            .cta-section { padding:52px 16px; }
            .cta-title { font-size:28px; }
            .footer { padding:40px 16px 20px; }
            .footer-inner { gap:20px; }
        }
        @media(max-width:480px) {
            .hero-title { font-size:34px; }
            .cat-grid { grid-template-columns:repeat(2,1fr); }
            .book-grid { grid-template-columns:1fr; }
            .footer-inner { grid-template-columns:1fr; }
            .stats-bar-inner { grid-template-columns:repeat(2,1fr); }
        }
    </style>
</head>
<body>

{{-- MARQUEE --}}
<div class="marquee-wrapper">
    <div class="marquee-track">
        @php $items = [
            ['🔥', 'Flash Sale — Up to 70% Off Selected Books'],
            ['📚', $totalBooks . '+ Books Available'],
            ['🚚', 'Fast Delivery Across Bangladesh'],
            ['💳', 'Secure Payment via bKash & Card'],
            ['✂️', 'Use Code SAVE10 for 10% Off'],
            ['📖', 'New Books Added Daily'],
            ['💰', 'Sell Your Books & Earn Money'],
            ['🏆', "Bangladesh's #1 Book Marketplace"],
            ['✨', 'Rare & Collectible Books Available'],
            ['📦', $totalSold . '+ Books Successfully Sold'],
        ]; @endphp
        @foreach(array_merge($items,$items) as $item)
            <span class="marquee-item">{{ $item[0] }} {{ $item[1] }}</span>
            <span class="marquee-sep" style="padding:0 4px;">◆</span>
        @endforeach
    </div>
</div>

{{-- NAVBAR --}}
<nav class="navbar">
    <a href="{{ route('home') }}" class="nav-brand">
        <div class="nav-brand-icon">📚</div>
        <div class="nav-brand-name">Book<span>Mart</span></div>
    </a>

    <button class="hamburger" id="hamburger" onclick="toggleMenu()">
        <span></span><span></span><span></span>
    </button>

    <div class="nav-links">
        <a href="{{ route('books.index') }}" class="nav-link">Browse</a>
        @auth
            @if(auth()->user()->isBuyer())
                <a href="{{ route('wishlist.index') }}" class="nav-link">♡ Wishlist</a>
                <a href="{{ route('cart.index') }}" class="nav-link">🛒 Cart</a>
                <a href="{{ route('orders.my') }}" class="nav-link">📦 Orders</a>
                <a href="{{ route('buyer.dashboard') }}" class="nav-link" style="color:#a78bfa;">👤 {{ auth()->user()->name }}</a>
            @elseif(auth()->user()->isSeller())
                <a href="{{ route('seller.dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('books.create') }}" class="nav-btn-primary">+ Sell Book</a>
            @elseif(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="nav-link">⚡ Admin</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="nav-btn-danger">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="nav-link">Login</a>
            <a href="{{ route('register') }}" class="nav-btn-primary">Get Started Free</a>
        @endauth
    </div>

    {{-- Mobile Menu --}}
    <div class="mobile-menu" id="mobile-menu">
        <a href="{{ route('books.index') }}" class="mobile-menu-link">📚 Browse Books</a>
        @auth
            <div class="mobile-divider"></div>
            @if(auth()->user()->isBuyer())
                <a href="{{ route('wishlist.index') }}" class="mobile-menu-link">♡ Wishlist</a>
                <a href="{{ route('cart.index') }}" class="mobile-menu-link">🛒 Cart</a>
                <a href="{{ route('orders.my') }}" class="mobile-menu-link">📦 My Orders</a>
                <a href="{{ route('buyer.dashboard') }}" class="mobile-menu-link">👤 {{ auth()->user()->name }}</a>
            @elseif(auth()->user()->isSeller())
                <a href="{{ route('seller.dashboard') }}" class="mobile-menu-link">📊 Dashboard</a>
                <a href="{{ route('books.create') }}" class="mobile-menu-link primary">+ Sell Book</a>
            @elseif(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="mobile-menu-link">⚡ Admin Panel</a>
            @endif
            <div class="mobile-divider"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="mobile-menu-link danger" style="width:100%;text-align:left;border:none;cursor:pointer;font-family:'Inter',sans-serif;">🚪 Logout</button>
            </form>
        @else
            <div class="mobile-divider"></div>
            <a href="{{ route('login') }}" class="mobile-menu-link">🔑 Login</a>
            <a href="{{ route('register') }}" class="mobile-menu-link primary">🚀 Get Started Free</a>
        @endauth
    </div>
</nav>

@if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
@endif

{{-- HERO --}}
<section class="hero">
    <div class="hero-grid-bg"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="hero-inner">
        <div>
            <div class="hero-badge"><span class="badge-dot"></span> Bangladesh's #1 Book Marketplace</div>
            <h1 class="hero-title">
                Discover<br>
                <span class="grad">Amazing</span><br>
                Books Online
            </h1>
            <p class="hero-desc">Buy & sell books at unbeatable prices. From rare classics to modern bestsellers — find your next great read on BookMart.</p>
            <div class="hero-btns">
                <a href="{{ route('books.index') }}" class="btn-hero-primary">📚 Browse Books</a>
                @auth
                    @if(auth()->user()->isSeller())
                        <a href="{{ route('books.create') }}" class="btn-hero-outline">+ Sell a Book</a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="btn-hero-outline">Start Selling →</a>
                @endauth
            </div>
            <form method="GET" action="{{ route('books.index') }}" class="hero-search">
                <input type="text" name="search" class="hero-search-input" placeholder="Search books, authors...">
                <button type="submit" class="hero-search-btn">🔍 Search</button>
            </form>
            <div class="hero-stats">
                <div><div class="hero-stat-num">{{ $totalBooks }}+</div><div class="hero-stat-label">Books Listed</div></div>
                <div class="stat-div"></div>
                <div><div class="hero-stat-num">{{ $totalSold }}+</div><div class="hero-stat-label">Books Sold</div></div>
                <div class="stat-div"></div>
                <div><div class="hero-stat-num">{{ $categories->count() }}+</div><div class="hero-stat-label">Categories</div></div>
                <div class="stat-div"></div>
                <div><div class="hero-stat-num">100%</div><div class="hero-stat-label">Secure</div></div>
            </div>
        </div>
        <div class="hero-right">
            @foreach($featuredBooks->take(4) as $i => $book)
                <a href="{{ route('books.show',$book) }}" class="hero-book-card" style="animation-delay:{{ $i*0.5 }}s">
                    @if($book->image)
                        <img src="{{ Storage::url($book->image) }}" alt="{{ $book->title }}" class="hero-book-img" loading="lazy">
                    @else
                        <div class="hero-book-placeholder">📚</div>
                    @endif
                    <div class="hero-book-title">{{ $book->title }}</div>
                    <div class="hero-book-price">৳{{ number_format($book->price,0) }}</div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- STATS BAR --}}
<div class="stats-bar">
    <div class="stats-bar-inner">
        <div class="sbc"><div class="sbc-icon">📚</div><div class="sbc-num" style="color:#a78bfa;">{{ $totalBooks }}+</div><div class="sbc-label">Books Listed</div></div>
        <div class="sbc"><div class="sbc-icon">🛒</div><div class="sbc-num" style="color:#f472b6;">{{ $totalSold }}+</div><div class="sbc-label">Books Sold</div></div>
        <div class="sbc"><div class="sbc-icon">🔒</div><div class="sbc-num" style="color:#34d399;">100%</div><div class="sbc-label">Secure Payment</div></div>
        <div class="sbc"><div class="sbc-icon">💬</div><div class="sbc-num" style="color:#fbbf24;">24/7</div><div class="sbc-label">Support</div></div>
    </div>
</div>

{{-- FLASH SALE --}}
<div class="flash-section">
    <div class="sw">
        <div class="flash-head">
            <div class="flash-title">🔥 Flash Sale <span style="font-size:13px;font-weight:600;color:rgba(255,255,255,0.4);">Limited time offers</span></div>
            <div class="flash-timer">
                <div class="timer-block"><div class="timer-num" id="timer-h">05</div><div class="timer-label">HRS</div></div>
                <span class="timer-sep">:</span>
                <div class="timer-block"><div class="timer-num" id="timer-m">59</div><div class="timer-label">MIN</div></div>
                <span class="timer-sep">:</span>
                <div class="timer-block"><div class="timer-num" id="timer-s">59</div><div class="timer-label">SEC</div></div>
            </div>
        </div>
        <div class="h-scroll">
            @foreach($bestSellers as $i => $book)
                @php $avg = round($book->reviews_avg_rating ?? 0,1); @endphp
                <a href="{{ route('books.show',$book) }}" class="book-sm">
                    <div style="position:relative;">
                        @if($book->image)
                            <img src="{{ Storage::url($book->image) }}" alt="{{ $book->title }}" class="book-sm-img" loading="lazy">
                        @else
                            <div class="book-sm-placeholder">📚</div>
                        @endif
                        <span class="rank-badge">#{{ $i+1 }}</span>
                        <span class="sale-badge">SALE</span>
                    </div>
                    <div class="book-sm-body">
                        <div class="book-sm-title">{{ $book->title }}</div>
                        <div class="book-sm-author">{{ $book->author }}</div>
                        <div class="book-sm-footer">
                            <span class="book-sm-price">৳{{ number_format($book->price,0) }}</span>
                            @if($avg > 0)<span class="book-sm-rating">★ {{ $avg }}</span>@endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

{{-- CATEGORIES --}}
<section class="section section-dark">
    <div class="sw">
        <div class="section-head-center">
            <div class="sbadge sbadge-purple" style="display:inline-flex;">🏷️ All Categories</div>
            <div class="section-title" style="text-align:center;">Browse by <span>Category</span></div>
            <div class="section-sub">Find exactly what you're looking for</div>
        </div>
        <div class="cat-grid">
            @foreach($categories as $cat)
                <a href="{{ route('books.index',['category'=>$cat->id]) }}" class="cat-card">
                    <span class="cat-icon">{{ $cat->icon ?? '📚' }}</span>
                    <div class="cat-name">{{ $cat->name }}</div>
                    <div class="cat-count">{{ $cat->books_count }} books</div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- NEW ARRIVALS --}}
<section class="section section-darker">
    <div class="sw">
        <div class="section-head">
            <div>
                <div class="sbadge sbadge-green">✨ Just Listed</div>
                <div class="section-title">New <span>Arrivals</span></div>
                <div class="section-sub">Freshly listed books just for you</div>
            </div>
            <a href="{{ route('books.index',['sort'=>'newest']) }}" class="section-link">See all →</a>
        </div>
        <div class="book-grid">
            @foreach($latestBooks as $book)
                @php
                    $avg = round($book->avg_rating ?? 0,1);
                    $condKey = explode(' ',$book->condition)[0];
                @endphp
                <a href="{{ route('books.show',$book) }}" class="book-lg">
                    @if($book->image)
                        <img src="{{ Storage::url($book->image) }}" alt="{{ $book->title }}" class="book-lg-img" loading="lazy">
                    @else
                        <div class="book-lg-placeholder">📚</div>
                    @endif
                    <div class="book-lg-body">
                        @if($book->category)
                            <span class="book-lg-cat">{{ $book->category->name }}</span>
                        @endif
                        <div class="book-lg-title">{{ $book->title }}</div>
                        <div class="book-lg-author">by {{ $book->author }}</div>
                        <div class="book-lg-footer">
                            <span class="book-lg-price">৳{{ number_format($book->price,0) }}</span>
                            <span class="cond-tag cond-{{ $condKey }}">{{ $book->condition }}</span>
                        </div>
                        @if($avg > 0)
                            <div style="font-size:11px;color:#fbbf24;margin-bottom:8px;">★ {{ $avg }}</div>
                        @endif
                        <span class="btn-view-book">View Book</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- MOST VIEWED --}}
<section class="section section-dark">
    <div class="sw">
        <div class="section-head">
            <div>
                <div class="sbadge sbadge-blue">👁️ Popular</div>
                <div class="section-title">Most <span>Viewed</span></div>
                <div class="section-sub">Books everyone is checking out</div>
            </div>
            <a href="{{ route('books.index',['sort'=>'most_viewed']) }}" class="section-link">See all →</a>
        </div>
        <div class="h-scroll">
            @foreach($mostViewed as $book)
                <a href="{{ route('books.show',$book) }}" class="book-sm">
                    @if($book->image)
                        <img src="{{ Storage::url($book->image) }}" alt="{{ $book->title }}" class="book-sm-img" loading="lazy">
                    @else
                        <div class="book-sm-placeholder">📚</div>
                    @endif
                    <div class="book-sm-body">
                        <div class="book-sm-title">{{ $book->title }}</div>
                        <div class="book-sm-author">{{ $book->author }}</div>
                        <div class="book-sm-footer">
                            <span class="book-sm-price">৳{{ number_format($book->price,0) }}</span>
                            <span style="font-size:11px;color:rgba(255,255,255,0.3);">👁️ {{ $book->view_count }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- PERSONALIZED (Buyer only) --}}
@auth
    @if(auth()->user()->isBuyer() && isset($personalizedBooks) && $personalizedBooks->count() > 0)
        <section class="section section-darker">
            <div class="sw">
                <div class="section-head">
                    <div>
                        <div class="sbadge sbadge-purple">🎯 For You</div>
                        <div class="section-title">Recommended <span>For You</span></div>
                        <div class="section-sub">Based on your order & wishlist history</div>
                    </div>
                    <a href="{{ route('books.index') }}" class="section-link">See all →</a>
                </div>
                <div class="h-scroll">
                    @foreach($personalizedBooks as $book)
                        @php $avg = round($book->reviews_avg_rating ?? 0,1); @endphp
                        <a href="{{ route('books.show',$book) }}" class="book-sm">
                            @if($book->image)
                                <img src="{{ Storage::url($book->image) }}" alt="{{ $book->title }}" class="book-sm-img" loading="lazy">
                            @else
                                <div class="book-sm-placeholder">📚</div>
                            @endif
                            <div class="book-sm-body">
                                <div class="book-sm-title">{{ $book->title }}</div>
                                <div class="book-sm-author">{{ $book->author }}</div>
                                <div class="book-sm-footer">
                                    <span class="book-sm-price">৳{{ number_format($book->price,0) }}</span>
                                    @if($avg > 0)<span class="book-sm-rating">★ {{ $avg }}</span>@endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endauth

{{-- HOW IT WORKS --}}
<section class="section section-dark">
    <div class="sw">
        <div class="section-head-center">
            <div class="sbadge sbadge-orange" style="display:inline-flex;">🚀 Simple Steps</div>
            <div class="section-title" style="text-align:center;">How It <span>Works</span></div>
            <div class="section-sub">Get your books in 3 easy steps</div>
        </div>
        <div class="steps-grid" style="margin-top:32px;">
            <div class="step-card">
                <div class="step-num-bg">01</div>
                <div class="step-icon-wrap" style="background:linear-gradient(135deg,rgba(124,58,237,0.3),rgba(168,85,247,0.2));">🔍</div>
                <div class="step-title">Browse & Search</div>
                <div class="step-desc">Search thousands of books by title, author, or category with powerful smart filters.</div>
            </div>
            <div class="step-card">
                <div class="step-num-bg">02</div>
                <div class="step-icon-wrap" style="background:linear-gradient(135deg,rgba(14,165,233,0.3),rgba(6,182,212,0.2));">🛒</div>
                <div class="step-title">Add to Cart</div>
                <div class="step-desc">Add your favourite books to cart and checkout securely with multiple payment options.</div>
            </div>
            <div class="step-card">
                <div class="step-num-bg">03</div>
                <div class="step-icon-wrap" style="background:linear-gradient(135deg,rgba(52,211,153,0.3),rgba(16,185,129,0.2));">📦</div>
                <div class="step-title">Fast Delivery</div>
                <div class="step-desc">Get your books delivered to your doorstep anywhere in Bangladesh quickly.</div>
            </div>
        </div>
    </div>
</section>

{{-- TESTIMONIALS --}}
<section class="section section-darker">
    <div class="sw">
        <div class="section-head-center">
            <div class="sbadge sbadge-yellow" style="display:inline-flex;">💬 Reviews</div>
            <div class="section-title" style="text-align:center;">What Our <span>Users Say</span></div>
            <div class="section-sub">Trusted by thousands of book lovers</div>
        </div>
        <div class="testimonial-grid" style="margin-top:32px;">
            <div class="testimonial-card">
                <div class="tcard-stars">★★★★★</div>
                <div class="tcard-text">"BookMart is amazing! Found rare books I couldn't find anywhere else. Delivery was super fast!"</div>
                <div class="tcard-author">
                    <div class="tcard-av">RK</div>
                    <div><div class="tcard-name">Rafiq Khan</div><div class="tcard-role">Buyer · Dhaka</div></div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="tcard-stars">★★★★★</div>
                <div class="tcard-text">"Sold 15 old textbooks in just one week! The seller dashboard is so easy to use."</div>
                <div class="tcard-author">
                    <div class="tcard-av" style="background:linear-gradient(135deg,#0ea5e9,#06b6d4);">TA</div>
                    <div><div class="tcard-name">Tasnim Ahmed</div><div class="tcard-role">Seller · Chittagong</div></div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="tcard-stars">★★★★☆</div>
                <div class="tcard-text">"Great prices on study materials. Saved a lot compared to buying new books from stores."</div>
                <div class="tcard-author">
                    <div class="tcard-av" style="background:linear-gradient(135deg,#10b981,#059669);">SH</div>
                    <div><div class="tcard-name">Sabina Hossain</div><div class="tcard-role">Buyer · Sylhet</div></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<div class="cta-section">
    <div style="position:relative;z-index:1;">
        <h2 class="cta-title">Ready to <span>Get Started?</span></h2>
        <p class="cta-sub">Join thousands of book lovers buying and selling on BookMart</p>
        <div class="cta-btns">
            <a href="{{ route('books.index') }}" class="btn-cta-primary">📚 Browse Books</a>
            @guest
                <a href="{{ route('register') }}" class="btn-cta-outline">Start Selling →</a>
            @endguest
        </div>
    </div>
</div>

{{-- FOOTER --}}
<footer class="footer">
    <div class="footer-inner">
        <div>
            <div class="footer-brand-name">Book<span>Mart</span></div>
            <p class="footer-desc">Bangladesh's #1 marketplace for buying and selling books. Connecting readers and sellers nationwide.</p>
        </div>
        <div>
            <div class="footer-head">Browse</div>
            <div class="footer-links">
                <a href="{{ route('books.index') }}" class="footer-link">All Books</a>
                @foreach($categories->take(4) as $cat)
                    <a href="{{ route('books.index',['category'=>$cat->id]) }}" class="footer-link">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
        <div>
            <div class="footer-head">Account</div>
            <div class="footer-links">
                @auth
                    @if(auth()->user()->isBuyer())
                        <a href="{{ route('buyer.dashboard') }}" class="footer-link">Dashboard</a>
                        <a href="{{ route('orders.my') }}" class="footer-link">My Orders</a>
                        <a href="{{ route('wishlist.index') }}" class="footer-link">Wishlist</a>
                    @elseif(auth()->user()->isSeller())
                        <a href="{{ route('seller.dashboard') }}" class="footer-link">Dashboard</a>
                        <a href="{{ route('books.create') }}" class="footer-link">Sell a Book</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="footer-link">Login</a>
                    <a href="{{ route('register') }}" class="footer-link">Register</a>
                @endauth
            </div>
        </div>
        <div>
            <div class="footer-head">Support</div>
            <div class="footer-links">
                <a href="#" class="footer-link">Help Center</a>
                <a href="#" class="footer-link">Shipping Policy</a>
                <a href="#" class="footer-link">Return Policy</a>
                <a href="#" class="footer-link">Privacy Policy</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="footer-copy">© {{ date('Y') }} BookMart. All rights reserved. Made with ❤️ in Bangladesh</div>
        <div class="footer-copy">📚 Connecting readers nationwide</div>
    </div>
</footer>

<script>
function toggleMenu() {
    document.getElementById('mobile-menu').classList.toggle('open');
    document.getElementById('hamburger').classList.toggle('open');
}
document.addEventListener('click', function(e) {
    const menu = document.getElementById('mobile-menu');
    const btn = document.getElementById('hamburger');
    if (!menu.contains(e.target) && !btn.contains(e.target)) {
        menu.classList.remove('open');
        btn.classList.remove('open');
    }
});

// Flash Sale Countdown
let endTime = new Date();
endTime.setHours(endTime.getHours() + 5, endTime.getMinutes() + 59, endTime.getSeconds() + 59);
function updateTimer() {
    const diff = endTime - new Date();
    if (diff <= 0) return;
    document.getElementById('timer-h').textContent = String(Math.floor(diff/3600000)).padStart(2,'0');
    document.getElementById('timer-m').textContent = String(Math.floor((diff%3600000)/60000)).padStart(2,'0');
    document.getElementById('timer-s').textContent = String(Math.floor((diff%60000)/1000)).padStart(2,'0');
}
updateTimer();
setInterval(updateTimer, 1000);
</script>
</body>
</html>