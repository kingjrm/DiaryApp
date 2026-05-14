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
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Pixelify Sans', cursive;
        }

        /* Navigation */
        .navbar {
            background: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .logo {
            font-size: 1.1rem;
            font-weight: 700;
            color: #a855f7;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            letter-spacing: -0.5px;
            white-space: nowrap;
        }

        .logo span {
            display: inline;
        }

        .nav-center {
            display: flex;
            gap: 2.5rem;
            align-items: center;
            flex: 1;
            justify-content: center;
        }

        .nav-center a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            transition: color 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.3px;
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
            color: #333;
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
            color: #333;
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
            margin-top: 70px;
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
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
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
            background: #1a1a1a;
            color: white;
            padding: 5rem 2rem;
            text-align: center;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        .cta-section p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Footer */
        footer {
            background: #f8f8f8;
            border-top: 1px solid #e0e0e0;
            padding: 3rem 2rem;
            text-align: center;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-bottom {
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
            <span>📔</span>
            <span>DiaryApp</span>
        </div>
        <div class="nav-center">
            <a href="#" onclick="location.reload(); return false;">Home Page</a>
            <a href="#features">Features</a>
            <a href="#security">Security</a>
            <a href="#support">Support</a>
        </div>
        <div class="nav-right">
            <a href="<?php echo url('login'); ?>">🔒 Login</a>
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
        <div class="hero-content">
            <h1>Your Life, Your Adventure</h1>
            <p class="hero-subtitle">Capture every moment, express every emotion, and build a lasting record of your journey</p>
            
            <div class="hero-cta">
                <a href="<?php echo url('register'); ?>" class="btn btn-primary">START WRITING FREE</a>
            </div>
        </div>
    </section>

    <!-- Three Feature Cards -->
    <section class="features">
        <div class="feature-card">
            <span class="feature-icon">❤️</span>
            <h3>From All Over The World</h3>
            <p>Write your diary anytime, anywhere. Access your thoughts from any device - mobile, tablet, or computer</p>
        </div>

        <div class="feature-card">
            <span class="feature-icon">🔒</span>
            <h3>Completely Secure Servers</h3>
            <p>Your thoughts are safe with us. Military-grade encryption protects your personal data and diary entries</p>
        </div>

        <div class="feature-card">
            <span class="feature-icon">💬</span>
            <h3>24/7 Free Support</h3>
            <p>Unlimited support through our help center, email, or ticket system. We're always here to help</p>
        </div>
    </section>

    <!-- Additional Features -->
    <section class="info-section">
        <h2>Why DiaryApp?</h2>
        
        <div class="features-grid">
            <div class="feature-full">
                <h3>✍️ Distraction-Free Writing</h3>
                <p>Write freely in a clean, minimalist interface. Focus on your thoughts without distractions.</p>
            </div>

            <div class="feature-full">
                <h3>🎨 Full Customization</h3>
                <p>Make your diary uniquely yours. Choose fonts, colors, styles, and backgrounds for each entry.</p>
            </div>

            <div class="feature-full">
                <h3>📸 Add Photos & Memories</h3>
                <p>Attach images to capture visual memories alongside your words and thoughts.</p>
            </div>

            <div class="feature-full">
                <h3>😊 Track Your Moods</h3>
                <p>Log daily moods and analyze emotional patterns over time to understand yourself better.</p>
            </div>

            <div class="feature-full">
                <h3>🔍 Powerful Search</h3>
                <p>Find any entry instantly. Search by date, mood, keywords, or browse chronologically.</p>
            </div>

            <div class="feature-full">
                <h3>📱 Mobile Ready</h3>
                <p>Write on the go. Our mobile-responsive design works perfectly on all devices.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2>Ready to Start?</h2>
        <p>Join thousands of people capturing their stories with DiaryApp. It only takes a minute to get started.</p>
        <div style="margin-top: 2rem;">
            <a href="<?php echo url('register'); ?>" class="btn btn-primary">Create Your Account</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-bottom">
                <p>&copy; 2024 DiaryApp. All rights reserved. | Keep your stories safe. Keep your memories alive.</p>
            </div>
        </div>
    </footer>

    <script>
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
            
            // Here you could add logic to translate the page
            console.log('Language changed to:', lang);
            
            // Reload page to apply language (optional)
            // window.location.reload();
        }

        // Load saved language preference on page load
        window.addEventListener('DOMContentLoaded', function() {
            const savedLang = localStorage.getItem('diaryAppLanguage');
            if (savedLang && savedLang !== 'en') {
                const langNames = {
                    'jp': 'JP',
                    'cn': 'CN',
                    'kr': 'KR',
                    'tl': 'PH'
                };
                if (langBtn) {
                    langBtn.textContent = langNames[savedLang] + ' ▼';
                }
            }
        });
    </script>
</body>
</html>
