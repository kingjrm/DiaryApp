<?php
$title = 'Register - Diary App';
include __DIR__ . '/../components/header.php';
?>

<style>
    .auth-shell {
        min-height: 100vh;
        position: relative;
        overflow: hidden;
        display: grid;
        place-items: center;
        padding: 5rem 1.25rem 2rem;
        color: #fff;
        isolation: isolate;
    }

    .auth-shell::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(6, 8, 20, 0.88), rgba(24, 18, 36, 0.72));
        z-index: -2;
    }

    .auth-bg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -3;
        filter: saturate(0.85) contrast(1.05);
    }

    .auth-grid {
        width: min(1180px, 100%);
        display: grid;
        grid-template-columns: 0.95fr 1.05fr;
        gap: 1.5rem;
        align-items: stretch;
    }

    .auth-brand {
        padding: 2rem;
        border-radius: 1.5rem;
        background: linear-gradient(180deg, rgba(255,255,255,0.10), rgba(255,255,255,0.04));
        border: 1px solid rgba(255,255,255,0.12);
        backdrop-filter: blur(18px);
        box-shadow: 0 30px 80px rgba(0,0,0,0.28);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 2rem;
    }

    .auth-brand .brand-title {
        font-family: 'Pixelify Sans', cursive;
        font-size: clamp(2.4rem, 4vw, 4.7rem);
        line-height: 0.95;
        letter-spacing: -0.04em;
        margin: 0 0 1rem;
    }

    .auth-brand .brand-copy {
        max-width: 32rem;
        color: rgba(255,255,255,0.86);
        font-size: 1.05rem;
    }

    .feature-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 1.25rem;
    }

    .feature-pill {
        padding: 0.6rem 0.9rem;
        border-radius: 999px;
        background: rgba(255,255,255,0.09);
        border: 1px solid rgba(255,255,255,0.13);
        color: rgba(255,255,255,0.9);
        font-size: 0.85rem;
        backdrop-filter: blur(10px);
    }

    .auth-card {
        border-radius: 1.5rem;
        background: rgba(255,255,255,0.88);
        color: #111827;
        border: 1px solid rgba(255,255,255,0.5);
        backdrop-filter: blur(18px);
        box-shadow: 0 30px 80px rgba(0,0,0,0.2);
        padding: 2rem;
    }

    .auth-heading {
        display: flex;
        align-items: center;
        gap: 0.9rem;
        margin-bottom: 1.5rem;
    }

    .auth-heading img {
        width: 64px;
        height: auto;
    }

    .auth-heading h2 {
        font-family: 'Pixelify Sans', cursive;
        font-size: 2rem;
        margin: 0;
        color: #111827;
    }

    .auth-heading p {
        color: #6b7280;
        margin-top: 0.2rem;
    }

    .auth-form label {
        display: block;
        margin-bottom: 0.4rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
    }

    .auth-form input {
        width: 100%;
        border-radius: 0.85rem;
        border: 1px solid #e5e7eb;
        background: rgba(255,255,255,0.9);
        padding: 0.9rem 1rem;
        font-size: 0.95rem;
        transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
    }

    .auth-form input:focus {
        outline: none;
        border-color: #a855f7;
        box-shadow: 0 0 0 4px rgba(168,85,247,0.14);
    }

    .auth-form .submit-btn {
        width: 100%;
        border: none;
        border-radius: 0.9rem;
        padding: 0.95rem 1rem;
        color: #fff;
        background: linear-gradient(135deg, #7c3aed, #a855f7);
        font-weight: 700;
        letter-spacing: 0.03em;
        box-shadow: 0 18px 35px rgba(124,58,237,0.25);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .auth-form .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 22px 45px rgba(124,58,237,0.32);
    }

    .auth-footer-link {
        color: #7c3aed;
        font-weight: 700;
        text-decoration: none;
    }

    .auth-footer-link:hover {
        text-decoration: underline;
    }

    @media (max-width: 960px) {
        .auth-grid {
            grid-template-columns: 1fr;
        }

        .auth-brand {
            display: none;
        }
    }
</style>

<section class="auth-shell">
    <video class="auth-bg" autoplay muted loop playsinline>
        <source src="<?php echo APP_URL; ?>/adventure_mydiary.mp4" type="video/mp4">
    </video>

    <div class="auth-grid">
        <aside class="auth-brand">
            <div>
                <img src="<?php echo APP_URL; ?>/logomydiary.png" alt="DiaryApp" class="brand-mark" style="width:96px;height:auto;display:block;margin-bottom:1rem;">
                <h1 class="brand-title">Your Life, Your Adventure</h1>
                <p class="brand-copy">Create your account and start keeping the moments that matter in one private place.</p>
                <div class="feature-pills">
                    <span class="feature-pill">Private diary</span>
                    <span class="feature-pill">Mood tracking</span>
                    <span class="feature-pill">Secure notes</span>
                </div>
            </div>
        </aside>

        <div class="auth-card">
            <div class="auth-heading">
                <img src="<?php echo APP_URL; ?>/logomydiaryDARK.png" alt="DiaryApp">
                <div>
                    <h2>Create Account</h2>
                    <p>Start your personal diary journey</p>
                </div>
            </div>

            <form class="auth-form space-y-5" action="<?php echo APP_URL; ?>/register.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="space-y-4">
                    <div>
                        <label for="name">Full Name</label>
                        <input id="name" name="name" type="text" required placeholder="Enter your full name">
                    </div>
                    <div>
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" required placeholder="Enter your email">
                    </div>
                    <div>
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" required minlength="6" placeholder="Enter your password (min 6 characters)">
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-user-plus" style="margin-right: 0.5rem;"></i>
                    Create Account
                </button>

                <div class="text-center" style="padding-top: 0.25rem;">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="<?php echo url('login'); ?>" class="auth-footer-link">Sign in</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../components/footer.php'; ?>