<?php
$title = 'Verify OTP - Diary App';
include __DIR__ . '/../components/header.php';
?>

<style>
    .auth-shell {
        min-height: 100vh;
        position: relative;
        overflow: hidden;
        display: grid;
        place-items: center;
        padding: 2rem 1.25rem;
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
    .auth-card {
        border-radius: 1.5rem;
        background: rgba(255,255,255,0.88);
        color: #111827;
        border: 1px solid rgba(255,255,255,0.5);
        backdrop-filter: blur(18px);
        box-shadow: 0 30px 80px rgba(0,0,0,0.2);
        padding: 2.5rem;
        width: 100%;
        max-width: 440px;
        text-align: center;
    }
    .auth-heading h2 {
        font-family: 'Pixelify Sans', cursive;
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #111827;
    }
    .auth-heading p {
        color: #6b7280;
        margin-bottom: 2rem;
    }
    .otp-input {
        width: 3.2rem;
        height: 3.8rem;
        text-align: center;
        font-size: 1.5rem;
        font-weight: 700;
        border-radius: 0.85rem;
        border: 1px solid #e5e7eb;
        background: rgba(255,255,255,0.9);
        color: #111827;
        transition: all 0.2s ease;
    }
    .otp-input:focus {
        outline: none;
        border-color: #a855f7;
        box-shadow: 0 0 0 4px rgba(168,85,247,0.14);
        transform: translateY(-2px);
    }
    .submit-btn {
        width: 100%;
        border: none;
        border-radius: 0.9rem;
        padding: 1rem;
        color: #fff;
        background: linear-gradient(135deg, #7c3aed, #a855f7);
        font-weight: 700;
        letter-spacing: 0.03em;
        box-shadow: 0 18px 35px rgba(124,58,237,0.25);
        transition: all 0.2s ease;
        margin-top: 1.5rem;
        cursor: pointer;
    }
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 22px 45px rgba(124,58,237,0.32);
    }
    .submit-btn.verified {
        background: linear-gradient(135deg, #059669, #10b981);
        box-shadow: 0 18px 35px rgba(16,185,129,0.25);
    }
    .auth-footer-link {
        color: #7c3aed;
        font-weight: 700;
        text-decoration: none;
    }
    .auth-footer-link:hover {
        text-decoration: underline;
    }
</style>

<section class="auth-shell">
    <video class="auth-bg" autoplay muted loop playsinline>
        <source src="<?php echo APP_URL; ?>/adventure_mydiary.mp4" type="video/mp4">
    </video>

    <div class="auth-card">
        <div class="auth-heading">
            <img src="<?php echo APP_URL; ?>/logomydiaryDARK.png" alt="DiaryApp" style="width: 64px; margin: 0 auto 1rem;">
            <h2>Verify Your Account</h2>
            <p>Enter the 6-digit code sent to your email</p>
        </div>

        <form id="otp-form" action="<?php echo APP_URL; ?>/verify-otp.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            
            <div class="flex justify-center space-x-2 mb-6">
                <input id="otp1" name="otp1" type="text" maxlength="1" class="otp-input" required>
                <input id="otp2" name="otp2" type="text" maxlength="1" class="otp-input" required>
                <input id="otp3" name="otp3" type="text" maxlength="1" class="otp-input" required>
                <input id="otp4" name="otp4" type="text" maxlength="1" class="otp-input" required>
                <input id="otp5" name="otp5" type="text" maxlength="1" class="otp-input" required>
                <input id="otp6" name="otp6" type="text" maxlength="1" class="otp-input" required>
            </div>
            
            <div class="text-center mb-4">
                <span class="text-sm text-gray-500 font-medium">Entered: <span id="otp-display" class="font-mono font-bold text-gray-700 tracking-widest">------</span></span>
            </div>
            <input type="hidden" id="otp" name="otp">
            
            <button type="submit" id="verify-btn" class="submit-btn flex items-center justify-center">
                <i class="fas fa-check mr-2"></i> <span class="ml-2">Verify Account</span>
            </button>
            
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600 font-medium">
                    Didn't receive the code?
                    <a href="<?php echo APP_URL; ?>/resend-otp" class="auth-footer-link">Resend OTP</a>
                </p>
                <div id="countdown" class="text-xs text-gray-500 mt-2 font-medium">Resend available in <span id="timer" class="font-bold">60</span>s</div>
            </div>
        </form>
    </div>
</section>

<script src="<?php echo APP_URL; ?>/public/js/verify_otp.js"></script>

<?php include __DIR__ . '/../components/footer.php'; ?>
