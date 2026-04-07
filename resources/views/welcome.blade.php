<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LaundryKu — Laundry Service</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,600,700,800,900&family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --teal:       #0abfbc;
            --teal-dark:  #089a98;
            --teal-deep:  #067070;
            --teal-light: #e0f7f7;
            --navy:       #1a3c5e;
            --white:      #ffffff;
            --cloud:      #f0fafa;
            --btn-dark:   #0d2d44;
        }

        html, body {
            height: 100%;
            font-family: 'Instrument Sans', sans-serif;
            background: var(--teal);
            overflow-x: hidden;
        }

        /* ── Navbar ───────────────────────────────── */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 60px;
            position: relative;
            z-index: 10;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            background: var(--navy);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-text h2 {
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            font-size: 16px;
            color: var(--navy);
            line-height: 1.1;
        }

        .logo-text p {
            font-size: 11px;
            color: var(--teal-deep);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 36px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--white);
            font-size: 15px;
            font-weight: 500;
            transition: opacity 0.2s;
        }

        .nav-links a:hover { opacity: 0.75; }
        .nav-links a.active { font-weight: 700; }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.2);
            border-radius: 50px;
            padding: 7px 14px;
            gap: 8px;
        }

        .search-bar input {
            background: none;
            border: none;
            outline: none;
            color: white;
            font-size: 14px;
            width: 100px;
        }

        .search-bar input::placeholder { color: rgba(255,255,255,0.7); }

        .btn-login {
            background: var(--white);
            color: var(--teal-deep);
            border: none;
            border-radius: 50px;
            padding: 8px 22px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }

        .btn-login:hover {
            background: var(--teal-light);
        }

        /* ── Hero Section ─────────────────────────── */
        .hero {
            display: flex;
            align-items: center;
            padding: 20px 60px 0;
            min-height: calc(100vh - 90px);
            position: relative;
            overflow: hidden;
        }

        .hero-left {
            flex: 1;
            position: relative;
            z-index: 2;
            padding-bottom: 80px;
        }

        /* Decorative leaves left */
        .leaves-left {
            position: absolute;
            left: 0;
            top: 80px;
            width: 130px;
            opacity: 0.55;
            animation: sway 5s ease-in-out infinite;
        }

        @keyframes sway {
            0%, 100% { transform: rotate(-3deg); }
            50%       { transform: rotate(3deg); }
        }

        .hero-title {
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            font-size: clamp(52px, 7vw, 86px);
            color: var(--white);
            line-height: 0.95;
            text-transform: uppercase;
            letter-spacing: -1px;
            margin-bottom: 22px;
            text-shadow: 0 4px 20px rgba(0,0,0,0.15);
            animation: fadeUp 0.8s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .hero-desc {
            font-size: 15px;
            color: rgba(255,255,255,0.88);
            line-height: 1.7;
            max-width: 420px;
            margin-bottom: 34px;
            animation: fadeUp 0.8s 0.15s ease both;
        }

        .btn-learn {
            display: inline-block;
            background: var(--btn-dark);
            color: var(--white);
            text-decoration: none;
            border: none;
            border-radius: 50px;
            padding: 14px 38px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            animation: fadeUp 0.8s 0.3s ease both;
        }

        .btn-learn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.25);
        }

        /* ── Right illustration ───────────────────── */
        .hero-right {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            position: relative;
            min-height: 480px;
        }

        /* Big soft circle behind illustration */
        .hero-circle {
            position: absolute;
            width: 420px;
            height: 420px;
            background: rgba(255,255,255,0.12);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .illustration {
            position: relative;
            z-index: 2;
            animation: fadeUp 0.8s 0.2s ease both;
        }

        /* Bubbles */
        .bubble {
            position: absolute;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.5);
            animation: floatBubble linear infinite;
        }

        @keyframes floatBubble {
            0%   { transform: translateY(0) scale(1); opacity: 0.6; }
            100% { transform: translateY(-40px) scale(1.1); opacity: 0; }
        }

        /* ── Cloud bottom ────────────────────────── */
        .clouds {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            pointer-events: none;
        }

        /* ── Leaves right ───────────────────────── */
        .leaves-right {
            position: absolute;
            right: 30px;
            bottom: 120px;
            width: 90px;
            opacity: 0.5;
            animation: sway 6s ease-in-out infinite reverse;
            z-index: 3;
        }

        /* ── Auth links fallback ─────────────────── */
        .auth-nav-fallback {
            display: none;
        }

        @media (max-width: 900px) {
            .navbar { padding: 16px 24px; }
            .nav-links { display: none; }
            .hero { flex-direction: column; padding: 24px; }
            .hero-right { min-height: 320px; margin-top: 20px; }
            .hero-circle { width: 280px; height: 280px; }
        }
    </style>
</head>
<body>

<!-- ── NAVBAR ────────────────────────────────────── -->
<nav class="navbar">
    <div class="logo-area">
        <div class="logo-text">
            <h2>LaundryKu</h2>
            <p>Your laundry partner</p>
        </div>
    </div>

    <ul class="nav-links">
        <li><a href="dashboard" class="active">Home</a></li>
        <li><a href="about">About</a></li>
        <li><a href="contact">Contact</a></li>
        <li><a href="service">Service</a></li>
    </ul>

    <div class="nav-right">
        <div class="search-bar">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <circle cx="6" cy="6" r="4.5" stroke="white" stroke-width="1.5"/>
                <path d="M10 10L13 13" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <input type="text" placeholder="Search...">
        </div>

        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-login">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-login">Log in</a>
            @endauth
        @endif
    </div>
</nav>

<!-- ── HERO ──────────────────────────────────────── -->
<section class="hero">

    <!-- Decorative leaves top-left -->
    <svg class="leaves-left" viewBox="0 0 130 200" fill="none" xmlns="http://www.w3.org/2000/svg">
        <ellipse cx="50" cy="60" rx="28" ry="50" fill="white" fill-opacity="0.7" transform="rotate(-20 50 60)"/>
        <ellipse cx="80" cy="40" rx="20" ry="38" fill="white" fill-opacity="0.5" transform="rotate(15 80 40)"/>
        <ellipse cx="30" cy="120" rx="22" ry="42" fill="white" fill-opacity="0.6" transform="rotate(-30 30 120)"/>
        <ellipse cx="70" cy="100" rx="16" ry="32" fill="white" fill-opacity="0.4" transform="rotate(10 70 100)"/>
        <line x1="50" y1="110" x2="50" y2="200" stroke="white" stroke-opacity="0.5" stroke-width="2"/>
        <line x1="80" y1="78" x2="80" y2="150" stroke="white" stroke-opacity="0.4" stroke-width="1.5"/>
    </svg>

    <!-- Left: Text content -->
    <div class="hero-left">
        <h1 class="hero-title">Laundry<br>Service</h1>
        <p class="hero-desc">
            DENGAN ANDA MENCUCI DI LAUNDRY.KU PAKAIAN ANDA AKAN TERLIHAT SEPERTI BARU LAGI, 
            KAMI MENGGUNAKAN DETERJEN BERKUALITAS DAN PROSES CUCI YANG TELITI UNTUK MENJAMIN HASIL CUCIAN YANG MEMUASKAN
            KAMI MENAWARKAN LAYANAN TERBAIK DENGAN HARGA YANG TERJANGKAU DAN PROSES CEPAT
            UNTUK MEMBUAT PAKAIAN ANDA SELALU BERSIH DAN WANGI
        </p>
        <a href="#" class="btn-learn">Learn more</a>
    </div>

    <!-- Right: Illustration -->
    <div class="hero-right">
        <div class="hero-circle"></div>

        <!-- Floating bubbles -->
        <div class="bubble" style="width:18px;height:18px;right:30%;bottom:55%;animation-duration:3.5s;"></div>
        <div class="bubble" style="width:12px;height:12px;right:20%;bottom:42%;animation-duration:4.2s;animation-delay:1s;"></div>
        <div class="bubble" style="width:22px;height:22px;right:45%;bottom:30%;animation-duration:5s;animation-delay:0.5s;"></div>
        <div class="bubble" style="width:10px;height:10px;right:55%;bottom:50%;animation-duration:3s;animation-delay:2s;"></div>
        <div class="bubble" style="width:16px;height:16px;right:15%;bottom:65%;animation-duration:4s;animation-delay:1.5s;"></div>

        <!-- Main illustration: washing machine + person + basket (SVG) -->
        <svg class="illustration" width="420" height="440" viewBox="0 0 420 440" fill="none" xmlns="http://www.w3.org/2000/svg">

            <!-- Window behind -->
            <rect x="190" y="30" width="160" height="160" rx="8" fill="white" fill-opacity="0.25"/>
            <line x1="270" y1="30" x2="270" y2="190" stroke="white" stroke-opacity="0.4" stroke-width="3"/>
            <line x1="190" y1="110" x2="350" y2="110" stroke="white" stroke-opacity="0.4" stroke-width="3"/>
            <!-- Window frame -->
            <rect x="190" y="30" width="160" height="160" rx="8" stroke="white" stroke-width="4" fill="none"/>

            <!-- ── Washing Machine ─────────────────────── -->
            <!-- Body -->
            <rect x="115" y="260" width="190" height="155" rx="10" fill="#d4d8e0"/>
            <rect x="115" y="260" width="190" height="30"  rx="10" fill="#b8bcc6"/>
            <!-- Control panel buttons -->
            <rect x="130" y="270" width="18" height="10" rx="3" fill="#5a9fd4"/>
            <rect x="155" y="270" width="18" height="10" rx="3" fill="#7abfe8"/>
            <rect x="180" y="270" width="12" height="10" rx="3" fill="#aaa"/>
            <circle cx="285" cy="276" r="8"  fill="#444" stroke="#666" stroke-width="1"/>
            <circle cx="285" cy="276" r="4"  fill="#222"/>
            <!-- Door circle -->
            <circle cx="210" cy="352" r="58" fill="white" fill-opacity="0.15"/>
            <circle cx="210" cy="352" r="52" stroke="white" stroke-width="5" fill="none"/>
            <circle cx="210" cy="352" r="40" fill="#a0b8c8" fill-opacity="0.5"/>
            <!-- Clothes inside drum -->
            <ellipse cx="200" cy="360" rx="22" ry="12" fill="#e8553a" fill-opacity="0.85" transform="rotate(-20 200 360)"/>
            <ellipse cx="225" cy="348" rx="16" ry="9"  fill="white"   fill-opacity="0.7"  transform="rotate(15 225 348)"/>
            <!-- Foam/soap at bottom -->
            <ellipse cx="210" cy="410" rx="90" ry="18" fill="white" fill-opacity="0.35"/>
            <ellipse cx="170" cy="407" rx="50" ry="12" fill="white" fill-opacity="0.4"/>
            <ellipse cx="260" cy="408" rx="45" ry="11" fill="white" fill-opacity="0.3"/>

            <!-- ── Laundry basket on top ───────────────── -->
            <!-- Basket body (dark) -->
            <rect x="178" y="196" width="98" height="68" rx="8" fill="#2a2a3a"/>
            <!-- Basket slats -->
            <line x1="194" y1="196" x2="194" y2="264" stroke="#3a3a4a" stroke-width="2"/>
            <line x1="210" y1="196" x2="210" y2="264" stroke="#3a3a4a" stroke-width="2"/>
            <line x1="226" y1="196" x2="226" y2="264" stroke="#3a3a4a" stroke-width="2"/>
            <line x1="242" y1="196" x2="242" y2="264" stroke="#3a3a4a" stroke-width="2"/>
            <line x1="258" y1="196" x2="258" y2="264" stroke="#3a3a4a" stroke-width="2"/>
            <!-- Clothes sticking out of basket -->
            <ellipse cx="200" cy="196" rx="14" ry="22" fill="#e8b84b" transform="rotate(-10 200 196)"/>
            <ellipse cx="230" cy="190" rx="12" ry="18" fill="#e8553a" transform="rotate(8 230 190)"/>
            <ellipse cx="260" cy="196" rx="10" ry="16" fill="#5a9fd4" transform="rotate(-5 260 196)"/>

            <!-- ── Person (cartoon style) ──────────────── -->
            <!-- Legs / pants (dark teal/navy) -->
            <rect x="290" y="340" width="28" height="80" rx="10" fill="#1a3c5e"/>
            <rect x="320" y="340" width="28" height="80" rx="10" fill="#1a3c5e"/>
            <!-- Shoes -->
            <rect x="285" y="408" width="38" height="18" rx="8" fill="#1a1a2e"/>
            <rect x="315" y="408" width="38" height="18" rx="8" fill="#1a1a2e"/>
            <!-- Body / shirt (orange-yellow) -->
            <rect x="280" y="250" width="90" height="100" rx="16" fill="#e8b84b"/>
            <!-- Neck -->
            <rect x="310" y="235" width="30" height="22" rx="8" fill="#c8906a"/>
            <!-- Head -->
            <ellipse cx="325" cy="210" rx="36" ry="38" fill="#d4956a"/>
            <!-- Hair -->
            <ellipse cx="325" cy="182" rx="36" ry="22" fill="#f5d48a"/>
            <ellipse cx="296" cy="200" rx="12" ry="28" fill="#f5d48a"/>
            <ellipse cx="354" cy="200" rx="12" ry="28" fill="#f5d48a"/>
            <!-- Eyes -->
            <ellipse cx="314" cy="210" rx="4" ry="5" fill="#2a1a0a"/>
            <ellipse cx="336" cy="210" rx="4" ry="5" fill="#2a1a0a"/>
            <!-- Smile -->
            <path d="M313 226 Q325 236 337 226" stroke="#8a5030" stroke-width="2" stroke-linecap="round" fill="none"/>

            <!-- ── Arm holding basket ──────────────────── -->
            <!-- Left arm extended to basket -->
            <rect x="240" y="268" width="44" height="22" rx="11" fill="#e8b84b" transform="rotate(-15 240 268)"/>
            <!-- Right arm -->
            <rect x="368" y="268" width="40" height="22" rx="11" fill="#e8b84b" transform="rotate(15 368 268)"/>
            <!-- Right hand holding basket -->
            <rect x="296" y="196" width="26" height="60" rx="10" fill="#e8b84b"/>

        </svg>

        <!-- Leaves bottom-right -->
        <svg class="leaves-right" viewBox="0 0 90 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="45" cy="50" rx="20" ry="40" fill="white" fill-opacity="0.6" transform="rotate(20 45 50)"/>
            <ellipse cx="65" cy="70" rx="15" ry="30" fill="white" fill-opacity="0.45" transform="rotate(-10 65 70)"/>
            <line x1="45" y1="90" x2="45" y2="120" stroke="white" stroke-opacity="0.5" stroke-width="2"/>
        </svg>
    </div>

    <!-- Cloud shapes at bottom -->
    <svg class="clouds" viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 80 Q80 40 160 70 Q240 100 320 60 Q400 20 480 60 Q560 100 640 70 Q720 40 800 65 Q880 90 960 60 Q1040 30 1120 60 Q1200 90 1280 65 Q1360 40 1440 70 L1440 120 L0 120 Z" fill="white" fill-opacity="0.18"/>
        <path d="M0 100 Q120 70 240 90 Q360 110 480 85 Q600 60 720 88 Q840 116 960 90 Q1080 64 1200 88 Q1320 112 1440 95 L1440 120 L0 120 Z" fill="white" fill-opacity="0.25"/>
    </svg>

</section>

</body>
</html>