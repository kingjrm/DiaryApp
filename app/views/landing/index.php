<?php
/**
 * Landing Page - DiaryApp
 * Inspired by modern SaaS landing pages with full-width hero background
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DiaryApp - Your Personal Digital Diary</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
            line-height: 1.6;
            color: #1a1a1a;
            background: #ffffff;
            scroll-behavior: smooth;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Pixelify Sans', cursive;
        }

        /* Navigation */
        .navbar {
            background: transparent;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: none;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }

        .navbar.scrolled {
            background: white;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .logo {
            height: 40px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: filter 0.3s ease;
        }

        .logo img {
            height: 100%;
            width: auto;
            object-fit: contain;
        }

        .nav-center {
            display: flex;
            gap: 2.5rem;
            align-items: center;
            flex: 1;
            justify-content: center;
        }

        .nav-center a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            transition: color 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .navbar.scrolled .nav-center a {
            color: #333;
        }

        .nav-center a:hover {
            color: #a855f7;
        }

        .nav-right {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-right a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .navbar.scrolled .nav-right a {
            color: #333;
        }

        .nav-right a:hover {
            color: #a855f7;
        }

        .lang-selector {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            position: relative;
        }

        .lang-dropdown {
            position: relative;
            display: inline-block;
        }

        .lang-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: white;
            font-weight: 500;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            transition: color 0.2s;
        }

        .navbar.scrolled .lang-btn {
            color: #333;
        }

        .lang-btn:hover {
            color: #a855f7;
        }

        .lang-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            border: 1px solid #eee;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            min-width: 150px;
            margin-top: 0.5rem;
        }

        .lang-menu.active {
            display: block;
        }

        .lang-menu a {
            display: block;
            padding: 0.7rem 1rem;
            color: #333;
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.2s;
            border-bottom: 1px solid #f0f0f0;
        }

        .lang-menu a:last-child {
            border-bottom: none;
        }

        .lang-menu a:hover {
            background: #f9f9f9;
            color: #a855f7;
        }

        /* Hero Section with Background */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .hero-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .hero-content {
            max-width: 800px;
            text-align: center;
            z-index: 2;
            animation: fadeInDown 1s ease-out;
            padding: 0 2rem;
            padding-top: 100px;
        }
        .floating-note {
            position: fixed;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%) rotate(4deg);
            width: min(22vw, 260px);
            max-width: 260px;
            z-index: 20;
            pointer-events: none;
            filter: drop-shadow(0 18px 30px rgba(0, 0, 0, 0.28));
            animation: noteFloat 4.5s ease-in-out infinite;
        }
        
        .floating-note img {
            display: block;
            width: 100%;
            height: auto;
        }
        
        @keyframes noteFloat {
            0%, 100% {
                transform: translateY(-50%) rotate(4deg) translateX(0);
            }
            50% {
                transform: translateY(-56%) rotate(2deg) translateX(-8px);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero h1 {
            font-size: 4rem;
            margin-bottom: 1rem;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -1px;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2.5rem;
            opacity: 0.95;
            line-height: 1.8;
            font-weight: 300;
        }

        .hero-cta {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.9rem 2.2rem;
            font-size: 0.95rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: white;
            color: #1a1a1a;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 1px solid white;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Features Section - 3 Column */
        .features {
            background: white;
            padding: 4rem 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            text-align: center;
            padding: 2rem;
        }

        .feature-icon {
            font-size: 1.4rem;
            margin-bottom: 0.8rem;
            display: block;
            line-height: 1;
        }

        .feature-icon svg {
            width: 1.4em;
            height: 1.4em;
            display: block;
            margin: 0 auto;
        }

        /* Card hover animations */
        .feature-card, .feature-full {
            transition: transform 0.28s ease, box-shadow 0.28s ease, background 0.28s ease;
            transform-origin: center;
            will-change: transform;
            overflow: hidden;
        }

        .feature-card:hover, .feature-full:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 14px 34px rgba(22, 22, 22, 0.08);
            background: #ffffff;
        }

        .feature-card:hover .feature-icon svg,
        .feature-full:hover h3 svg {
            transform: translateY(-2px) scale(1.02);
            filter: drop-shadow(0 6px 14px rgba(168, 85, 247, 0.08));
        }

        .feature-card h3 {
            color: #1a1a1a;
            margin-bottom: 0.8rem;
            font-size: 1.2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .feature-card p {
            color: #666;
            line-height: 1.7;
            font-size: 0.95rem;
        }

        /* Info Sections */
        .info-section {
            padding: 5rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
            scroll-margin-top: 80px;
        }

        .info-section h2 {
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #1a1a1a;
            font-weight: 700;
            text-align: center;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .feature-full {
            background: #f8f8f8;
            padding: 2.5rem;
            border-radius: 8px;
        }

        .feature-full h3 {
            color: #a855f7;
            margin-bottom: 1rem;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .feature-full p {
            color: #666;
            line-height: 1.7;
        }

        /* CTA Section */
        .cta-section {
            background: #f5f5f5;
            color: #1a1a1a;
            padding: 6rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(168, 85, 247, 0.05);
            border-radius: 50%;
        }

        .cta-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 300px;
            height: 300px;
            background: rgba(168, 85, 247, 0.03);
            border-radius: 50%;
        }

        .cta-icon {
            width: 50px;
            height: 50px;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .cta-icon svg {
            width: 100%;
            height: 100%;
            fill: #a855f7;
        }

        .cta-section h2 {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .cta-section p {
            font-size: 1.15rem;
            margin-bottom: 2.5rem;
            opacity: 0.95;
            line-height: 1.6;
        }

        /* Contact Section (redesigned) */
        .contact-section {
            padding: 3.5rem 2rem;
            max-width: 1200px;
            margin: 2rem auto;
        }

        .contact-section h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #111827;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 2rem;
            align-items: start;
        }

        .contact-panel {
            padding: 1.5rem 1.5rem 1.5rem 0;
        }

        .contact-logo {
            width: 120px;
            display: block;
            margin-bottom: 1rem;
        }

        .contact-card .lead {
            color: #374151;
            font-size: 1rem;
            margin-bottom: 0.85rem;
            line-height: 1.5;
            font-weight: 500;
        }

        .contact-card {
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
            border-radius: 10px;
            padding: 1rem;
            border: 1px solid #eef2ff;
        }

        .contact-method {
            display: flex;
            gap: 0.9rem;
            align-items: center;
            padding: 0.85rem;
            border-radius: 8px;
            background: #fff;
            border: 1px solid #f1f5f9;
            margin-bottom: 0.8rem;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .contact-method:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(2,6,23,0.06);
        }

        .contact-method svg { width: 28px; height: 28px; flex: 0 0 28px; }

        .contact-method .method-text { color: #111827; font-weight:600; }

        .support-hours { color:#6b7280; font-size:0.95rem; margin-top:0.5rem; }

        .quick-links { display:flex; gap:0.6rem; margin-top:0.8rem; flex-wrap:wrap; }

        .quick-link { padding:0.45rem 0.8rem; background:#f3f4f6; border-radius:999px; color:#374151; font-size:0.9rem; text-decoration:none; border:1px solid #e6e6e6; }

        .contact-info p { color: #374151; line-height: 1.7; margin-bottom: 0.75rem; }

        .contact-form-card {
            background: #fff;
            padding: 1.25rem;
            border-radius: 10px;
            border: 1px solid #eef2ff;
            box-shadow: 0 10px 30px rgba(16,24,40,0.06);
        }

        .contact-form label { display:block; margin-bottom: 0.5rem; font-size: 0.9rem; color:#374151; }
        .contact-form input, .contact-form textarea { width:100%; padding:0.75rem; border:1px solid #e6e6e6; border-radius:8px; font-size:0.95rem; transition: border-color .18s, box-shadow .18s; }
        .contact-form input:focus, .contact-form textarea:focus { outline: none; border-color: #a855f7; box-shadow: 0 6px 20px rgba(168,85,247,0.08); }
        .contact-form .btn { width: 100%; }

        .contact-success { display:none; padding:0.9rem 1rem; border-radius:6px; background:#ecfdf5; color:#065f46; margin-bottom:0.75rem; border:1px solid #bbf7d0; }

        @media (max-width: 900px) {
            .contact-grid { grid-template-columns: 1fr; }
            .contact-form-card { margin-top: 1rem; }
            .contact-logo { width: 100px; }
        }

        /* Footer */
        footer {
            background: linear-gradient(to bottom, #1a1a1a, #0f0f0f);
            border-top: 1px solid #333;
            color: white;
            padding: 5rem 2rem 2rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto 3rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
        }

        .footer-section h3 {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            color: #a855f7;
            font-weight: 700;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.8rem;
        }

        .footer-section ul li a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.2s;
            font-size: 0.95rem;
        }

        .footer-section ul li a:hover {
            color: #a855f7;
        }

        .footer-section p {
            color: #ccc;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .footer-social {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .footer-social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(168, 85, 247, 0.1);
            color: #a855f7;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 1.2rem;
        }

        .footer-social a svg {
            width: 20px;
            height: 20px;
            fill: #a855f7;
        }

        .footer-social a:hover {
            background: #a855f7;
            color: white;
        }

        .footer-social a:hover svg {
            fill: white;
        }

        .footer-bottom {
            border-top: 1px solid #333;
            padding-top: 2rem;
            text-align: center;
            color: #999;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .hero-cta {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .nav-center {
                display: none;
            }

            .nav-right {
                gap: 1rem;
            }

            .logo {
                font-size: 0.9rem;
            }

            .lang-menu {
                min-width: 120px;
            }

            .features {
                grid-template-columns: 1fr;
            }
            .floating-note {
                display: none;
            }

            .info-section h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">
            <img src="logomydiary.png" alt="DiaryApp" id="navLogo">
        </div>
        <div class="nav-center">
            <a href="#" onclick="location.reload(); return false;">Home Page</a>
            <a href="#features">Features</a>
            <a href="#security">Security</a>
            <a href="#support">Support</a>
        </div>
        <div class="nav-right">
            <a href="<?php echo url('login'); ?>">Login</a>
            <div class="lang-dropdown">
                <button class="lang-btn" id="langBtn">EN ▼</button>
                <div class="lang-menu" id="langMenu">
                    <a href="#" onclick="setLanguage('en', event)">English (EN)</a>
                    <a href="#" onclick="setLanguage('jp', event)">日本語 (JP)</a>
                    <a href="#" onclick="setLanguage('cn', event)">中文 (CN)</a>
                    <a href="#" onclick="setLanguage('kr', event)">한국어 (KR)</a>
                    <a href="#" onclick="setLanguage('tl', event)">Tagalog (PH)</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <video autoplay muted loop class="hero-video">
            <source src="http://localhost/DiaryApp/adventure_mydiary.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="floating-note" aria-hidden="true">
            <img src="MyDiaryNOTES.png" alt="">
        </div>
        <div class="hero-content">
            <h1 data-i18n-key="hero-title">Your Life, Your Adventure</h1>
            <p class="hero-subtitle" data-i18n-key="hero-subtitle">Capture every moment, express every emotion, and build a lasting record of your journey</p>
            
            <div class="hero-cta">
                <a href="<?php echo url('register'); ?>" class="btn btn-primary" data-i18n-key="hero-cta">START WRITING FREE</a>
            </div>
        </div>
    </section>

    <!-- Three Feature Cards -->
    <section class="features">
        <div class="feature-card">
            <span class="feature-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></span>
            <h3 data-i18n-key="card-hearts">From All Over The World</h3>
            <p data-i18n-key="card-hearts-desc">Write your diary anytime, anywhere. Access your thoughts from any device - mobile, tablet, or computer</p>
        </div>

        <div class="feature-card">
            <span class="feature-icon"><svg viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4" fill="none" stroke="currentColor" stroke-width="2"/></svg></span>
            <h3 data-i18n-key="card-secure">Completely Secure Servers</h3>
            <p data-i18n-key="card-secure-desc">Your thoughts are safe with us. Military-grade encryption protects your personal data and diary entries</p>
        </div>

        <div class="feature-card">
            <span class="feature-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span>
            <h3 data-i18n-key="card-support">24/7 Free Support</h3>
            <p data-i18n-key="card-support-desc">Unlimited support through our help center, email, or ticket system. We're always here to help</p>
        </div>
    </section>

    <!-- Additional Features -->
    <section class="info-section" id="features">
        <h2 data-i18n-key="features-title">Features</h2>
        
        <div class="features-grid">
            <div class="feature-full">
                <h3 data-i18n-key="full-1-title"><svg style="display: inline; width: 12px; height: 12px; margin-right: 4px; vertical-align: -2px;" viewBox="0 0 24 24" fill="currentColor"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg> Distraction-Free Writing</h3>
                <p data-i18n-key="full-1-desc">Write freely in a clean, minimalist interface. Focus on your thoughts without distractions.</p>
            </div>

            <div class="feature-full">
                <h3 data-i18n-key="full-2-title">🎨 Full Customization</h3>
                <p data-i18n-key="full-2-desc">Make your diary uniquely yours. Choose fonts, colors, styles, and backgrounds for each entry.</p>
            </div>

            <div class="feature-full">
                <h3 data-i18n-key="full-3-title">📸 Add Photos & Memories</h3>
                <p data-i18n-key="full-3-desc">Attach images to capture visual memories alongside your words and thoughts.</p>
            </div>

            <div class="feature-full">
                <h3 data-i18n-key="full-4-title">😊 Track Your Moods</h3>
                <p data-i18n-key="full-4-desc">Log daily moods and analyze emotional patterns over time to understand yourself better.</p>
            </div>

            <div class="feature-full">
                <h3 data-i18n-key="full-5-title"><svg style="display: inline; width: 12px; height: 12px; margin-right: 4px; vertical-align: -2px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg> Powerful Search</h3>
                <p data-i18n-key="full-5-desc">Find any entry instantly. Search by date, mood, keywords, or browse chronologically.</p>
            </div>

            <div class="feature-full">
                <h3 data-i18n-key="full-6-title"><svg style="display: inline; width: 12px; height: 12px; margin-right: 4px; vertical-align: -2px;" viewBox="0 0 24 24" fill="currentColor"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><path d="M12 18h.01" stroke="currentColor" stroke-width="2" fill="none"/></svg> Mobile Ready</h3>
                <p data-i18n-key="full-6-desc">Write on the go. Our mobile-responsive design works perfectly on all devices.</p>
            </div>
        </div>
    </section>

    <!-- Security Section -->
    <section class="info-section" id="security">
        <h2 data-i18n-key="security-title">Security</h2>
        
        <div class="features-grid">
            <div class="feature-full">
                <h3 data-i18n-key="sec-1-title"><svg style="display: inline; width: 12px; height: 12px; margin-right: 4px; vertical-align: -2px;" viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4" fill="none" stroke="currentColor" stroke-width="2"/></svg> End-to-End Encryption</h3>
                <p data-i18n-key="sec-1-desc">Your diary entries are encrypted with military-grade security. Only you can access your data.</p>
            </div>

            <div class="feature-full">
                <h3 data-i18n-key="sec-2-title"><svg style="display: inline; width: 12px; height: 12px; margin-right: 4px; vertical-align: -2px;" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg> Secure Servers</h3>
                <p data-i18n-key="sec-2-desc">We use industry-leading security practices to protect your personal information and ensure data integrity.</p>
            </div>

            <div class="feature-full">
                <h3 data-i18n-key="sec-3-title"><svg style="display: inline; width: 12px; height: 12px; margin-right: 4px; vertical-align: -2px;" viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4" fill="none" stroke="currentColor" stroke-width="2"/></svg> Password Protection</h3>
                <p data-i18n-key="sec-3-desc">Your account is protected by encrypted passwords. Two-factor authentication available for added security.</p>
            </div>

            <div class="feature-full">
                <h3 data-i18n-key="sec-4-title"><svg style="display: inline; width: 12px; height: 12px; margin-right: 4px; vertical-align: -2px;" viewBox="0 0 24 24" fill="currentColor"><path d="M4 7h16M4 12h16M4 17h16M3 4h18a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1z" fill="none" stroke="currentColor" stroke-width="2"/></svg> Privacy Policy</h3>
                <p data-i18n-key="sec-4-desc">Your privacy is our priority. We never share or sell your data. Full transparency in our privacy policy.</p>
            </div>

            <div class="feature-full">
                <h3 data-i18n-key="sec-5-title"><svg style="display: inline; width: 12px; height: 12px; margin-right: 4px; vertical-align: -2px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Regular Audits</h3>
                <p data-i18n-key="sec-5-desc">Security audits and updates ensure your data remains protected against evolving threats.</p>
            </div>

            <div class="feature-full">
                <h3 data-i18n-key="sec-6-title"><svg style="display: inline; width: 12px; height: 12px; margin-right: 4px; vertical-align: -2px;" viewBox="0 0 24 24" fill="currentColor"><path d="M22 16.13v5a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-5M11.5 3.5L4 11m9.5-7.5L20 11M12 4v9"/></svg> Secure Backups</h3>
                <p data-i18n-key="sec-6-desc">Your entries are automatically backed up securely so you never lose your memories.</p>
            </div>
        </div>
    </section>

    <!-- Support Section -->
    <section class="info-section" id="support">
        <h2 data-i18n-key="support-title">Support</h2>
        
        <div class="features-grid">
            <div class="feature-full">
                <h3 data-i18n-key="sup-1-title"><svg style="display: inline; width: 12px; height: 12px; margin-right: 4px; vertical-align: -2px;" viewBox="0 0 24 24" fill="currentColor"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg> 24/7 Chat Support</h3>
                <p data-i18n-key="sup-1-desc">Get help anytime. Our support team is available round the clock via live chat to assist you.</p>
            </div>

            <div class="feature-full">
                <h3 data-i18n-key="sup-2-title"><svg style="display: inline; width: 12px; height: 12px; margin-right: 4px; vertical-align: -2px;" viewBox="0 0 24 24" fill="currentColor"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6" fill="none" stroke="currentColor" stroke-width="2"/></svg> Email Support</h3>
                <p data-i18n-key="sup-2-desc">Send us an email and our team will respond within 24 hours with solutions and assistance.</p>
            </div>

            <div class="feature-full">
                <h3 data-i18n-key="sup-3-title"><svg style="display: inline; width: 12px; height: 12px; margin-right: 4px; vertical-align: -2px;" viewBox="0 0 24 24" fill="currentColor"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 4h14a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H6.5a2.5 2.5 0 0 1-2.5-2.5V4z" fill="none" stroke="currentColor" stroke-width="2"/></svg> Knowledge Base</h3>
                <p data-i18n-key="sup-3-desc">Access our comprehensive help documentation with guides, tutorials, and FAQs.</p>
            </div>

            <div class="feature-full">
                <h3 data-i18n-key="sup-4-title"><svg style="display: inline; width: 12px; height: 12px; margin-right: 4px; vertical-align: -2px;" viewBox="0 0 24 24" fill="currentColor"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg> Video Tutorials</h3>
                <p data-i18n-key="sup-4-desc">Learn how to use DiaryApp with our video tutorials covering all features and use cases.</p>
            </div>

            <div class="feature-full">
                <h3 data-i18n-key="sup-5-title"><svg style="display: inline; width: 12px; height: 12px; margin-right: 4px; vertical-align: -2px;" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="1"/><path d="M12 1v6m6-3l-4.24 4.24M1 12h6m-3 6l4.24-4.24M23 12h-6m3 6l-4.24-4.24M12 17v6M12 1a5 5 0 0 0-5 5M12 1a5 5 0 0 1 5 5" fill="none" stroke="currentColor" stroke-width="2"/></svg> Bug Reports</h3>
                <p data-i18n-key="sup-5-desc">Found an issue? Report bugs directly to our team and we'll prioritize fixes for you.</p>
            </div>

            <div class="feature-full">
                <h3 data-i18n-key="sup-6-title"><svg style="display: inline; width: 12px; height: 12px; margin-right: 4px; vertical-align: -2px;" viewBox="0 0 24 24" fill="currentColor"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><circle cx="9" cy="10" r="1"/><circle cx="12" cy="10" r="1"/><circle cx="15" cy="10" r="1"/></svg> Feature Requests</h3>
                <p data-i18n-key="sup-6-desc">Your feedback matters! Suggest new features and vote on others to shape DiaryApp's future.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <div class="cta-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                </svg>
            </div>
            <h2 data-i18n-key="cta-title">Ready to Start Your Journey?</h2>
            <p data-i18n-key="cta-desc">Join thousands of people capturing their stories with DiaryApp. It only takes a minute to get started and begin preserving your most precious memories.</p>
            <div style="margin-top: 2.5rem;">
                <a href="<?php echo url('register'); ?>" class="btn btn-primary" data-i18n-key="cta-btn">Create Your Account</a>
            </div>
        </div>
    </section>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <h2 data-i18n-key="contact-title">Contact Us</h2>
        <div class="contact-grid">
            <div class="contact-panel">
                <div class="contact-card">
                    <img src="logomydiary.png" alt="My Diary" class="contact-logo">
                    <p class="lead" data-i18n-key="contact-lead">Questions? Send us a message — we’ll usually reply within 24 hours.</p>

                    <div class="contact-method" role="button" tabindex="0">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M3 8.5V18a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.5" fill="#eef2ff" stroke="#a855f7" stroke-width="1.2"/><path d="M3 8.5L12 13l9-4.5" fill="none" stroke="#7c3aed" stroke-width="1.2"/></svg>
                        <div>
                            <div class="method-text" data-i18n-key="contact-email-text">support@diaryapp.local</div>
                            <div class="support-hours" data-i18n-key="contact-email-hours">Email support — reply within 24 hours</div>
                        </div>
                    </div>

                    <div class="contact-method" role="button" tabindex="0">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 3 5.18 2 2 0 0 1 5 3h3a2 2 0 0 1 2 1.72c.12.9.39 1.77.8 2.56a2 2 0 0 1-.45 2.11L9.7 11.7a16 16 0 0 0 6.6 6.6l1.3-1.3a2 2 0 0 1 2.11-.45c.79.41 1.66.68 2.56.8A2 2 0 0 1 22 16.92z" fill="#fff7ed" stroke="#f59e0b" stroke-width="1.2"/></svg>
                        <div>
                            <div class="method-text" data-i18n-key="contact-phone-text">+1 (555) 123-4567</div>
                            <div class="support-hours" data-i18n-key="contact-phone-hours">Phone support — 9am–6pm (Mon–Fri)</div>
                        </div>
                    </div>

                    <div class="quick-links" aria-hidden="false">
                        <a class="quick-link" href="#support" data-i18n-key="quick-help">Help Center</a>
                        <a class="quick-link" href="#support" data-i18n-key="quick-chat">Live Chat</a>
                        <a class="quick-link" href="#support" data-i18n-key="quick-ticket">Submit Ticket</a>
                    </div>
                </div>
            </div>
            <div class="contact-form-card">
                <form id="contactForm" class="contact-form">
                    <div class="contact-success" id="contactSuccess" role="status" aria-live="polite"></div>
                    <label for="contact-name">Name</label>
                    <input id="contact-name" name="name" type="text" required>

                    <label for="contact-email">Email</label>
                    <input id="contact-email" name="email" type="email" required>

                    <label for="contact-message">Message</label>
                    <textarea id="contact-message" name="message" rows="5" required></textarea>

                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>DiaryApp</h3>
                <p>Capture every moment, express every emotion, and build a lasting record of your journey. Keep your stories safe. Keep your memories alive.</p>
                <div class="footer-social">
                    <a href="#" title="Twitter" aria-label="Twitter">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7z"/></svg>
                    </a>
                    <a href="#" title="Facebook" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M18 2h-3a6 6 0 00-6 6v3H7v4h2v8h4v-8h3l1-4h-4V8a1 1 0 011-1h3z"/></svg>
                    </a>
                    <a href="#" title="Instagram" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" fill="#f5f5f5"/><circle cx="17.5" cy="6.5" r="1.5" fill="#f5f5f5"/></svg>
                    </a>
                    <a href="#" title="LinkedIn" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                    </a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Product</h3>
                <ul>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#security">Security</a></li>
                    <li><a href="#support">Support</a></li>
                    <li><a href="<?php echo url('login'); ?>">Login</a></li>
                    <li><a href="<?php echo url('register'); ?>">Sign Up</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Company</h3>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Press</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Legal</h3>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Cookie Policy</a></li>
                    <li><a href="#">GDPR</a></li>
                    <li><a href="#">Accessibility</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p data-i18n-key="footer-copy">&copy; 2024 DiaryApp. All rights reserved. | Made with 💜 for your memories.</p>
        </div>
    </footer>

    <script>
        // Translation object
        const translations = {
            en: {
                'home': 'Home Page',
                'features': 'Features',
                'security': 'Security',
                'support': 'Support',
                'login': 'Login',
                'hero-title': 'Your Life, Your Adventure',
                'hero-subtitle': 'Capture every moment, express every emotion, and build a lasting record of your journey',
                'hero-cta': 'START WRITING FREE',
                'card-hearts': 'From All Over The World',
                'card-hearts-desc': 'Write your diary anytime, anywhere. Access your thoughts from any device - mobile, tablet, or computer',
                'card-secure': 'Completely Secure Servers',
                'card-secure-desc': 'Your thoughts are safe with us. Military-grade encryption protects your personal data and diary entries',
                'card-support': '24/7 Free Support',
                'card-support-desc': 'Unlimited support through our help center, email, or ticket system. We\'re always here to help',
                'features-title': 'Features',
                'security-title': 'Security',
                'support-title': 'Support',
                'cta-title': 'Ready to Start Your Journey?',
                'cta-desc': 'Join thousands of people capturing their stories with DiaryApp. It only takes a minute to get started and begin preserving your most precious memories.',
                'cta-btn': 'Create Your Account'
                ,
                'contact-title': 'Contact Us',
                'contact-lead': 'Questions? Send us a message — we\'ll usually reply within 24 hours.',
                'contact-email-text': 'support@diaryapp.local',
                'contact-email-hours': 'Email support — reply within 24 hours',
                'contact-phone-text': '+1 (555) 123-4567',
                'contact-phone-hours': 'Phone support — 9am–6pm (Mon–Fri)',
                'quick-help': 'Help Center',
                'quick-chat': 'Live Chat',
                'quick-ticket': 'Submit Ticket',
                'footer-copy': '© 2024 DiaryApp. All rights reserved. | Made with 💜 for your memories.'
                ,
                'full-1-title': 'Distraction-Free Writing',
                'full-1-desc': 'Write freely in a clean, minimalist interface. Focus on your thoughts without distractions.',
                'full-2-title': 'Full Customization',
                'full-2-desc': 'Make your diary uniquely yours. Choose fonts, colors, styles, and backgrounds for each entry.',
                'full-3-title': 'Add Photos & Memories',
                'full-3-desc': 'Attach images to capture visual memories alongside your words and thoughts.',
                'full-4-title': 'Track Your Moods',
                'full-4-desc': 'Log daily moods and analyze emotional patterns over time to understand yourself better.',
                'full-5-title': 'Powerful Search',
                'full-5-desc': 'Find any entry instantly. Search by date, mood, keywords, or browse chronologically.',
                'full-6-title': 'Mobile Ready',
                'full-6-desc': 'Write on the go. Our mobile-responsive design works perfectly on all devices.',

                'sec-1-title': 'End-to-End Encryption',
                'sec-1-desc': 'Your diary entries are encrypted with military-grade security. Only you can access your data.',
                'sec-2-title': 'Secure Servers',
                'sec-2-desc': 'We use industry-leading security practices to protect your personal information and ensure data integrity.',
                'sec-3-title': 'Password Protection',
                'sec-3-desc': 'Your account is protected by encrypted passwords. Two-factor authentication available for added security.',
                'sec-4-title': 'Privacy Policy',
                'sec-4-desc': 'Your privacy is our priority. We never share or sell your data. Full transparency in our privacy policy.',
                'sec-5-title': 'Regular Audits',
                'sec-5-desc': 'Security audits and updates ensure your data remains protected against evolving threats.',
                'sec-6-title': 'Secure Backups',
                'sec-6-desc': 'Your entries are automatically backed up securely so you never lose your memories.',

                'sup-1-title': '24/7 Chat Support',
                'sup-1-desc': 'Get help anytime. Our support team is available round the clock via live chat to assist you.',
                'sup-2-title': 'Email Support',
                'sup-2-desc': 'Send us an email and our team will respond within 24 hours with solutions and assistance.',
                'sup-3-title': 'Knowledge Base',
                'sup-3-desc': 'Access our comprehensive help documentation with guides, tutorials, and FAQs.',
                'sup-4-title': 'Video Tutorials',
                'sup-4-desc': 'Learn how to use DiaryApp with our video tutorials covering all features and use cases.',
                'sup-5-title': 'Bug Reports',
                'sup-5-desc': 'Found an issue? Report bugs directly to our team and we\'ll prioritize fixes for you.',
                'sup-6-title': 'Feature Requests',
                'sup-6-desc': 'Your feedback matters! Suggest new features and vote on others to shape DiaryApp\'s future.'
            },
            jp: {
                'home': 'ホーム',
                'features': '機能',
                'security': 'セキュリティ',
                'support': 'サポート',
                'login': 'ログイン',
                'hero-title': 'あなたの人生、あなたの冒険',
                'hero-subtitle': 'すべての瞬間を捉え、あらゆる感情を表現し、あなたの旅の永遠の記録を作成してください',
                'hero-cta': '無料で執筆を開始',
                'card-hearts': '世界中から',
                'card-hearts-desc': 'いつでもどこでも日記を書いてください。モバイル、タブレット、コンピューターから思考にアクセスできます',
                'card-secure': '完全に安全なサーバー',
                'card-secure-desc': 'あなたの思考は私たちと一緒に安全です。軍用レベルの暗号化があなたの個人データと日記エントリを保護します',
                'card-support': '24時間無料サポート',
                'card-support-desc': 'ヘルプセンター、メール、またはチケットシステムを通じた無制限のサポート。私たちはいつでもお手伝いします',
                'features-title': '機能',
                'security-title': 'セキュリティ',
                'support-title': 'サポート',
                'cta-title': 'あなたの旅を始める準備はいいですか？',
                'cta-desc': '何千人もの人々がDiaryAppで彼らの物語を撮影しています。始めるのに1分しかかかりません。',
                'cta-btn': 'アカウントを作成'
                ,
                'contact-title': 'お問い合わせ',
                'contact-lead': 'ご質問はありますか？ メッセージを送ってください — 通常24時間以内に返信します。',
                'contact-email-text': 'support@diaryapp.local',
                'contact-email-hours': 'メールサポート — 24時間以内に返信',
                'contact-phone-text': '+1 (555) 123-4567',
                'contact-phone-hours': '電話サポート — 平日 9:00–18:00',
                'quick-help': 'ヘルプセンター',
                'quick-chat': 'ライブチャット',
                'quick-ticket': 'チケットを送信',
                'full-1-title': 'Distraction-Free Writing',
                'full-1-desc': 'Write freely in a clean, minimalist interface. Focus on your thoughts without distractions.',
                'full-2-title': 'Full Customization',
                'full-2-desc': 'Make your diary uniquely yours. Choose fonts, colors, styles, and backgrounds for each entry.',
                'full-3-title': 'Add Photos & Memories',
                'full-3-desc': 'Attach images to capture visual memories alongside your words and thoughts.',
                'full-4-title': 'Track Your Moods',
                'full-4-desc': 'Log daily moods and analyze emotional patterns over time to understand yourself better.',
                'full-5-title': 'Powerful Search',
                'full-5-desc': 'Find any entry instantly. Search by date, mood, keywords, or browse chronologically.',
                'full-6-title': 'Mobile Ready',
                'full-6-desc': 'Write on the go. Our mobile-responsive design works perfectly on all devices.',

                'sec-1-title': 'End-to-End Encryption',
                'sec-1-desc': 'Your diary entries are encrypted with military-grade security. Only you can access your data.',
                'sec-2-title': 'Secure Servers',
                'sec-2-desc': 'We use industry-leading security practices to protect your personal information and ensure data integrity.',
                'sec-3-title': 'Password Protection',
                'sec-3-desc': 'Your account is protected by encrypted passwords. Two-factor authentication available for added security.',
                'sec-4-title': 'Privacy Policy',
                'sec-4-desc': 'Your privacy is our priority. We never share or sell your data. Full transparency in our privacy policy.',
                'sec-5-title': 'Regular Audits',
                'sec-5-desc': 'Security audits and updates ensure your data remains protected against evolving threats.',
                'sec-6-title': 'Secure Backups',
                'sec-6-desc': 'Your entries are automatically backed up securely so you never lose your memories.',

                'sup-1-title': '24/7 Chat Support',
                'sup-1-desc': 'Get help anytime. Our support team is available round the clock via live chat to assist you.',
                'sup-2-title': 'Email Support',
                'sup-2-desc': 'Send us an email and our team will respond within 24 hours with solutions and assistance.',
                'sup-3-title': 'Knowledge Base',
                'sup-3-desc': 'Access our comprehensive help documentation with guides, tutorials, and FAQs.',
                'sup-4-title': 'Video Tutorials',
                'sup-4-desc': 'Learn how to use DiaryApp with our video tutorials covering all features and use cases.',
                'sup-5-title': 'Bug Reports',
                'sup-5-desc': 'Found an issue? Report bugs directly to our team and we\'ll prioritize fixes for you.',
                'sup-6-title': 'Feature Requests',
                'sup-6-desc': 'Your feedback matters! Suggest new features and vote on others to shape DiaryApp\'s future.',

                'footer-copy': '© 2024 DiaryApp。無断複写・転載を禁じます。'
            },
            cn: {
                'home': '首页',
                'features': '功能',
                'security': '安全',
                'support': '支持',
                'login': '登录',
                'hero-title': '你的生活，你的冒险',
                'hero-subtitle': '捕捉每一刻，表达每一种情感，建立你旅程的永久记录',
                'hero-cta': '开始免费书写',
                'card-hearts': '来自世界各地',
                'card-hearts-desc': '随时随地写日记。从移动设备、平板电脑或计算机访问您的想法',
                'card-secure': '完全安全的服务器',
                'card-secure-desc': '您的想法与我们一起是安全的。军用级加密保护您的个人数据和日记条目',
                'card-support': '24/7 免费支持',
                'card-support-desc': '通过帮助中心、电子邮件或票务系统提供无限支持。我们随时准备帮忙',
                'features-title': '功能',
                'security-title': '安全',
                'support-title': '支持',
                'cta-title': '准备好开始你的旅程了吗？',
                'cta-desc': '加入数千人使用 DiaryApp 记录他们的故事。开始只需一分钟。',
                'cta-btn': '创建您的帐户'
                ,
                'contact-title': '联系我们',
                'contact-lead': '有问题吗？给我们留言 — 我们通常会在24小时内回复。',
                'contact-email-text': 'support@diaryapp.local',
                'contact-email-hours': '邮件支持 — 24小时内回复',
                'contact-phone-text': '+1 (555) 123-4567',
                'contact-phone-hours': '电话支持 — 周一至周五 9:00–18:00',
                'quick-help': '帮助中心',
                'quick-chat': '在线聊天',
                'quick-ticket': '提交工单',
                'full-1-title': 'Distraction-Free Writing',
                'full-1-desc': 'Write freely in a clean, minimalist interface. Focus on your thoughts without distractions.',
                'full-2-title': 'Full Customization',
                'full-2-desc': 'Make your diary uniquely yours. Choose fonts, colors, styles, and backgrounds for each entry.',
                'full-3-title': 'Add Photos & Memories',
                'full-3-desc': 'Attach images to capture visual memories alongside your words and thoughts.',
                'full-4-title': 'Track Your Moods',
                'full-4-desc': 'Log daily moods and analyze emotional patterns over time to understand yourself better.',
                'full-5-title': 'Powerful Search',
                'full-5-desc': 'Find any entry instantly. Search by date, mood, keywords, or browse chronologically.',
                'full-6-title': 'Mobile Ready',
                'full-6-desc': 'Write on the go. Our mobile-responsive design works perfectly on all devices.',

                'sec-1-title': 'End-to-End Encryption',
                'sec-1-desc': 'Your diary entries are encrypted with military-grade security. Only you can access your data.',
                'sec-2-title': 'Secure Servers',
                'sec-2-desc': 'We use industry-leading security practices to protect your personal information and ensure data integrity.',
                'sec-3-title': 'Password Protection',
                'sec-3-desc': 'Your account is protected by encrypted passwords. Two-factor authentication available for added security.',
                'sec-4-title': 'Privacy Policy',
                'sec-4-desc': 'Your privacy is our priority. We never share or sell your data. Full transparency in our privacy policy.',
                'sec-5-title': 'Regular Audits',
                'sec-5-desc': 'Security audits and updates ensure your data remains protected against evolving threats.',
                'sec-6-title': 'Secure Backups',
                'sec-6-desc': 'Your entries are automatically backed up securely so you never lose your memories.',

                'sup-1-title': '24/7 Chat Support',
                'sup-1-desc': 'Get help anytime. Our support team is available round the clock via live chat to assist you.',
                'sup-2-title': 'Email Support',
                'sup-2-desc': 'Send us an email and our team will respond within 24 hours with solutions and assistance.',
                'sup-3-title': 'Knowledge Base',
                'sup-3-desc': 'Access our comprehensive help documentation with guides, tutorials, and FAQs.',
                'sup-4-title': 'Video Tutorials',
                'sup-4-desc': 'Learn how to use DiaryApp with our video tutorials covering all features and use cases.',
                'sup-5-title': 'Bug Reports',
                'sup-5-desc': 'Found an issue? Report bugs directly to our team and we\'ll prioritize fixes for you.',
                'sup-6-title': 'Feature Requests',
                'sup-6-desc': 'Your feedback matters! Suggest new features and vote on others to shape DiaryApp\'s future.',

                'footer-copy': '© 2024 DiaryApp。保留所有权利。'
            },
            kr: {
                'home': '홈',
                'features': '기능',
                'security': '보안',
                'support': '지원',
                'login': '로그인',
                'hero-title': '당신의 삶, 당신의 모험',
                'hero-subtitle': '모든 순간을 포착하고, 모든 감정을 표현하고, 여정의 영구 기록을 만드세요',
                'hero-cta': '무료 작성 시작',
                'card-hearts': '전 세계에서',
                'card-hearts-desc': '언제 어디서나 일기를 쓰세요. 모바일, 태블릿 또는 컴퓨터에서 생각에 액세스하세요',
                'card-secure': '완전히 안전한 서버',
                'card-secure-desc': '당신의 생각은 우리와 함께 안전합니다. 군용 암호화가 개인 데이터와 일기 항목을 보호합니다',
                'card-support': '24/7 무료 지원',
                'card-support-desc': '도움말 센터, 이메일 또는 티켓 시스템을 통한 무제한 지원. 우리는 항상 도움을 드릴 준비가 되어 있습니다',
                'features-title': '기능',
                'security-title': '보안',
                'support-title': '지원',
                'cta-title': '여정을 시작할 준비가 되셨습니까?',
                'cta-desc': 'DiaryApp으로 이야기를 작성하는 수천 명의 사람들과 함께하세요. 시작하는 데 1분만 소요됩니다.',
                'cta-btn': '계정 만들기'
                ,
                'contact-title': '문의하기',
                'contact-lead': '질문이 있으신가요? 메시지를 보내주세요 — 일반적으로 24시간 내에 답장드립니다.',
                'contact-email-text': 'support@diaryapp.local',
                'contact-email-hours': '이메일 지원 — 24시간 내 응답',
                'contact-phone-text': '+1 (555) 123-4567',
                'contact-phone-hours': '전화 지원 — 월~금 9:00–18:00',
                'quick-help': '도움말 센터',
                'quick-chat': '라이브 채팅',
                'quick-ticket': '티켓 제출',
                'full-1-title': 'Distraction-Free Writing',
                'full-1-desc': 'Write freely in a clean, minimalist interface. Focus on your thoughts without distractions.',
                'full-2-title': 'Full Customization',
                'full-2-desc': 'Make your diary uniquely yours. Choose fonts, colors, styles, and backgrounds for each entry.',
                'full-3-title': 'Add Photos & Memories',
                'full-3-desc': 'Attach images to capture visual memories alongside your words and thoughts.',
                'full-4-title': 'Track Your Moods',
                'full-4-desc': 'Log daily moods and analyze emotional patterns over time to understand yourself better.',
                'full-5-title': 'Powerful Search',
                'full-5-desc': 'Find any entry instantly. Search by date, mood, keywords, or browse chronologically.',
                'full-6-title': 'Mobile Ready',
                'full-6-desc': 'Write on the go. Our mobile-responsive design works perfectly on all devices.',

                'sec-1-title': 'End-to-End Encryption',
                'sec-1-desc': 'Your diary entries are encrypted with military-grade security. Only you can access your data.',
                'sec-2-title': 'Secure Servers',
                'sec-2-desc': 'We use industry-leading security practices to protect your personal information and ensure data integrity.',
                'sec-3-title': 'Password Protection',
                'sec-3-desc': 'Your account is protected by encrypted passwords. Two-factor authentication available for added security.',
                'sec-4-title': 'Privacy Policy',
                'sec-4-desc': 'Your privacy is our priority. We never share or sell your data. Full transparency in our privacy policy.',
                'sec-5-title': 'Regular Audits',
                'sec-5-desc': 'Security audits and updates ensure your data remains protected against evolving threats.',
                'sec-6-title': 'Secure Backups',
                'sec-6-desc': 'Your entries are automatically backed up securely so you never lose your memories.',

                'sup-1-title': '24/7 Chat Support',
                'sup-1-desc': 'Get help anytime. Our support team is available round the clock via live chat to assist you.',
                'sup-2-title': 'Email Support',
                'sup-2-desc': 'Send us an email and our team will respond within 24 hours with solutions and assistance.',
                'sup-3-title': 'Knowledge Base',
                'sup-3-desc': 'Access our comprehensive help documentation with guides, tutorials, and FAQs.',
                'sup-4-title': 'Video Tutorials',
                'sup-4-desc': 'Learn how to use DiaryApp with our video tutorials covering all features and use cases.',
                'sup-5-title': 'Bug Reports',
                'sup-5-desc': 'Found an issue? Report bugs directly to our team and we\'ll prioritize fixes for you.',
                'sup-6-title': 'Feature Requests',
                'sup-6-desc': 'Your feedback matters! Suggest new features and vote on others to shape DiaryApp\'s future.',

                'footer-copy': '© 2024 DiaryApp. 판권 소유.'
            },
            tl: {
                'home': 'Tahanan',
                'features': 'Mga Katangian',
                'security': 'Seguridad',
                'support': 'Suporta',
                'login': 'Mag-log in',
                'hero-title': 'Ang Iyong Buhay, Ang Iyong Pakikipagsapalaran',
                'hero-subtitle': 'Kunin ang bawat sandali, ipahayag ang bawat emosyon, at lumikha ng isang pangmatagalang rekord ng iyong paglalakbay',
                'hero-cta': 'MAGSIMULANG MAGSULAT NANG LIBRE',
                'card-hearts': 'Mula sa Buong Mundo',
                'card-hearts-desc': 'Sumulat ng iyong diary anumang oras, kahit saan. I-access ang iyong mga pag-iisip mula sa anumang device - mobile, tablet, o computer',
                'card-secure': 'Lubos na Secure na Mga Servidor',
                'card-secure-desc': 'Ang iyong mga pag-iisip ay ligtas sa amin. Ang military-grade encryption ay nagpoprotekta sa iyong personal na datos at mga entry sa diary',
                'card-support': '24/7 Libreng Suporta',
                'card-support-desc': 'Walang hanggang suporta sa pamamagitan ng aming help center, email, o ticket system. Lagi kaming handa na tumulong',
                'features-title': 'Mga Katangian',
                'security-title': 'Seguridad',
                'support-title': 'Suporta',
                'cta-title': 'Handa na ba kayong Magsimula ng Iyong Paglalakbay?',
                'cta-desc': 'Sumali sa libu-libong taong kumukuha ng kanilang mga kuwento sa DiaryApp. Tumatagal lamang ng isang minuto upang magsimula.',
                'cta-btn': 'Lumikha ng Iyong Account'
                ,
                'contact-title': 'Makipag-ugnayan sa Amin',
                'contact-lead': 'May mga tanong? Magpadala ng mensahe — karaniwang sasagot kami sa loob ng 24 oras.',
                'contact-email-text': 'support@diaryapp.local',
                'contact-email-hours': 'Suporta sa email — sumagot sa loob ng 24 oras',
                'contact-phone-text': '+1 (555) 123-4567',
                'contact-phone-hours': 'Suporta sa telepono — 9am–6pm (Lun–Biyernes)',
                'quick-help': 'Help Center',
                'quick-chat': 'Live Chat',
                'quick-ticket': 'Mag-submit ng Ticket',
                'full-1-title': 'Distraction-Free Writing',
                'full-1-desc': 'Write freely in a clean, minimalist interface. Focus on your thoughts without distractions.',
                'full-2-title': 'Full Customization',
                'full-2-desc': 'Make your diary uniquely yours. Choose fonts, colors, styles, and backgrounds for each entry.',
                'full-3-title': 'Add Photos & Memories',
                'full-3-desc': 'Attach images to capture visual memories alongside your words and thoughts.',
                'full-4-title': 'Track Your Moods',
                'full-4-desc': 'Log daily moods and analyze emotional patterns over time to understand yourself better.',
                'full-5-title': 'Powerful Search',
                'full-5-desc': 'Find any entry instantly. Search by date, mood, keywords, or browse chronologically.',
                'full-6-title': 'Mobile Ready',
                'full-6-desc': 'Write on the go. Our mobile-responsive design works perfectly on all devices.',

                'sec-1-title': 'End-to-End Encryption',
                'sec-1-desc': 'Your diary entries are encrypted with military-grade security. Only you can access your data.',
                'sec-2-title': 'Secure Servers',
                'sec-2-desc': 'We use industry-leading security practices to protect your personal information and ensure data integrity.',
                'sec-3-title': 'Password Protection',
                'sec-3-desc': 'Your account is protected by encrypted passwords. Two-factor authentication available for added security.',
                'sec-4-title': 'Privacy Policy',
                'sec-4-desc': 'Your privacy is our priority. We never share or sell your data. Full transparency in our privacy policy.',
                'sec-5-title': 'Regular Audits',
                'sec-5-desc': 'Security audits and updates ensure your data remains protected against evolving threats.',
                'sec-6-title': 'Secure Backups',
                'sec-6-desc': 'Your entries are automatically backed up securely so you never lose your memories.',

                'sup-1-title': '24/7 Chat Support',
                'sup-1-desc': 'Get help anytime. Our support team is available round the clock via live chat to assist you.',
                'sup-2-title': 'Email Support',
                'sup-2-desc': 'Send us an email and our team will respond within 24 hours with solutions and assistance.',
                'sup-3-title': 'Knowledge Base',
                'sup-3-desc': 'Access our comprehensive help documentation with guides, tutorials, and FAQs.',
                'sup-4-title': 'Video Tutorials',
                'sup-4-desc': 'Learn how to use DiaryApp with our video tutorials covering all features and use cases.',
                'sup-5-title': 'Bug Reports',
                'sup-5-desc': 'Found an issue? Report bugs directly to our team and we\'ll prioritize fixes for you.',
                'sup-6-title': 'Feature Requests',
                'sup-6-desc': 'Your feedback matters! Suggest new features and vote on others to shape DiaryApp\'s future.',

                'footer-copy': '© 2024 DiaryApp. Lahat ng karapatan ay nakalaan.'
            }
        };

        function translatePage(lang) {
            const t = translations[lang] || translations.en;
            
            // Generic data-i18n mapping for elements
            document.querySelectorAll('[data-i18n-key]').forEach(el => {
                const key = el.getAttribute('data-i18n-key');
                if (key && t[key]) {
                    el.textContent = t[key];
                }
            });

            // Translate navigation
            const navHome = document.querySelector('.nav-center a[href="#"]');
            if (navHome) navHome.textContent = t['home'];
            
            const navFeatures = document.querySelector('.nav-center a[href="#features"]');
            if (navFeatures) navFeatures.textContent = t['features'];
            
            const navSecurity = document.querySelector('.nav-center a[href="#security"]');
            if (navSecurity) navSecurity.textContent = t['security'];
            
            const navSupport = document.querySelector('.nav-center a[href="#support"]');
            if (navSupport) navSupport.textContent = t['support'];
            
            const navLogin = document.querySelector('.nav-right a');
            if (navLogin) navLogin.textContent = t['login'];
            
            // Translate hero section
            const heroTitle = document.querySelector('.hero h1');
            if (heroTitle) heroTitle.textContent = t['hero-title'];
            
            const heroSubtitle = document.querySelector('.hero-subtitle');
            if (heroSubtitle) heroSubtitle.textContent = t['hero-subtitle'];
            
            const heroCta = document.querySelector('.hero-cta .btn');
            if (heroCta) heroCta.textContent = t['hero-cta'];
            
            // feature cards and feature-full sections are translated via data-i18n-key attributes
        }

        // Language Dropdown Toggle
        const langBtn = document.getElementById('langBtn');
        const langMenu = document.getElementById('langMenu');

        if (langBtn) {
            langBtn.addEventListener('click', function(e) {
                e.preventDefault();
                langMenu.classList.toggle('active');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.lang-dropdown')) {
                    langMenu.classList.remove('active');
                }
            });
        }

        // Set Language
        function setLanguage(lang, e) {
            e.preventDefault();
            
            const langNames = {
                'en': 'EN',
                'jp': 'JP',
                'cn': 'CN',
                'kr': 'KR',
                'tl': 'PH'
            };

            // Store language preference
            localStorage.setItem('diaryAppLanguage', lang);
            
            // Update button text
            if (langBtn) {
                langBtn.textContent = langNames[lang] + ' ▼';
            }
            
            // Close menu
            langMenu.classList.remove('active');
            
            // Translate the page
            translatePage(lang);
        }

        // Load saved language preference on page load
        window.addEventListener('DOMContentLoaded', function() {
            const savedLang = localStorage.getItem('diaryAppLanguage') || 'en';
            const langNames = {
                'en': 'EN',
                'jp': 'JP',
                'cn': 'CN',
                'kr': 'KR',
                'tl': 'PH'
            };
            if (langBtn) {
                langBtn.textContent = langNames[savedLang] + ' ▼';
            }
            
            // Apply saved language on page load
            translatePage(savedLang);

            // Smooth scroll for navigation links
            const navLinks = document.querySelectorAll('.nav-center a');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href && href.startsWith('#')) {
                        e.preventDefault();
                        const targetId = href.substring(1);
                        const targetElement = document.getElementById(targetId);
                        if (targetElement) {
                            targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }
                });
            });

            // Navbar background change on scroll
            const navbar = document.querySelector('.navbar');
            const heroSection = document.querySelector('.hero');
            const navLogo = document.getElementById('navLogo');
            
            if (navbar && heroSection && navLogo) {
                window.addEventListener('scroll', function() {
                    const heroBottom = heroSection.offsetTop + heroSection.offsetHeight;
                    if (window.scrollY >= heroBottom) {
                        navbar.classList.add('scrolled');
                        navLogo.src = 'logomydiaryDARK.png';
                    } else {
                        navbar.classList.remove('scrolled');
                        navLogo.src = 'logomydiary.png';
                    }
                });
            }

            // Contact form handler - client-side success (no backend)
            const contactForm = document.getElementById('contactForm');
            const contactSuccess = document.getElementById('contactSuccess');
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const name = (document.getElementById('contact-name').value || '').trim();
                    const email = (document.getElementById('contact-email').value || '').trim();
                    const message = (document.getElementById('contact-message').value || '').trim();
                    const submitBtn = contactForm.querySelector('button[type="submit"]');
                    if (!name || !email || !message) {
                        contactSuccess.style.display = 'block';
                        contactSuccess.style.background = '#fff4f2';
                        contactSuccess.style.borderColor = '#ffddd6';
                        contactSuccess.style.color = '#7f1d1d';
                        contactSuccess.textContent = 'Please complete all fields before sending.';
                        setTimeout(() => { contactSuccess.style.display = 'none'; }, 3500);
                        return;
                    }
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Sending...';
                    // Simulate send delay
                    setTimeout(() => {
                        contactSuccess.style.display = 'block';
                        contactSuccess.style.background = '#ecfdf5';
                        contactSuccess.style.borderColor = '#bbf7d0';
                        contactSuccess.style.color = '#065f46';
                        contactSuccess.textContent = 'Thanks — your message was sent. We will reply within 24 hours.';
                        contactForm.reset();
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Send Message';
                        setTimeout(() => { contactSuccess.style.display = 'none'; }, 7000);
                    }, 800);
                });
            }
        });
    </script>
</body>
</html>
