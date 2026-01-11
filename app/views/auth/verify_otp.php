<?php
$title = 'Verify OTP - Diary App';
include __DIR__ . '/../components/header.php';
?>

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="glass rounded-xl p-8 neumorphism">
            <div class="text-center">
                <h2 class="text-xl font-bold text-gray-900 mb-2">Verify Your Account</h2>
                <p class="text-sm text-gray-600">Enter the 6-digit code sent to your email</p>
            </div>
            <form id="otp-form" class="mt-8 space-y-6" action="<?php echo APP_URL; ?>/auth/verify-otp" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div>
                    <label for="otp" class="block text-xs font-medium text-gray-700 mb-2">OTP Code</label>
                    <div class="flex space-x-2 mb-4">
                        <input id="otp1" name="otp1" type="text" maxlength="1" class="w-12 h-12 text-center text-lg font-bold border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset" required>
                        <input id="otp2" name="otp2" type="text" maxlength="1" class="w-12 h-12 text-center text-lg font-bold border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset" required>
                        <input id="otp3" name="otp3" type="text" maxlength="1" class="w-12 h-12 text-center text-lg font-bold border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset" required>
                        <input id="otp4" name="otp4" type="text" maxlength="1" class="w-12 h-12 text-center text-lg font-bold border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset" required>
                        <input id="otp5" name="otp5" type="text" maxlength="1" class="w-12 h-12 text-center text-lg font-bold border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset" required>
                        <input id="otp6" name="otp6" type="text" maxlength="1" class="w-12 h-12 text-center text-lg font-bold border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset" required>
                    </div>
                    <div class="text-center mb-4">
                        <span class="text-sm text-gray-500">Entered: <span id="otp-display" class="font-mono font-bold text-gray-700">------</span></span>
                    </div>
                    <input type="hidden" id="otp" name="otp">
                </div>
                <div>
                    <button type="submit" id="verify-btn" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-check"></i>
                        </span>
                        Verify Account
                    </button>
                </div>
                <div class="text-center">
                    <p class="text-xs text-gray-600">
                        Didn't receive the code?
                        <a href="<?php echo APP_URL; ?>/auth/resend-otp" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">Resend OTP</a>
                    </p>
                    <div id="countdown" class="text-xs text-gray-500 mt-2">Resend available in <span id="timer">60</span> seconds</div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('input[id^="otp"]');
    const verifyBtn = document.getElementById('verify-btn');
    const countdownEl = document.getElementById('countdown');
    const timerEl = document.getElementById('timer');

    // Focus on first input
    if (otpInputs.length > 0) {
        otpInputs[0].focus();
    }

    // Simple OTP input handling
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function() {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');

            // Move to next input if a digit was entered
            if (this.value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }

            updateDisplay();
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && this.value === '' && index > 0) {
                otpInputs[index - 1].focus();
            }
        });

        // Handle paste - distribute across all inputs
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            const digits = paste.replace(/[^0-9]/g, '').substring(0, 6).split('');

            digits.forEach((digit, i) => {
                if (otpInputs[i]) {
                    otpInputs[i].value = digit;
                }
            });

            updateDisplay();

            // Focus on last input or next empty one
            const lastInput = otpInputs[digits.length - 1] || otpInputs[5];
            lastInput.focus();
        });
    });

    function updateDisplay() {
        const otp = Array.from(otpInputs).map(input => input.value).join('');
        const display = document.getElementById('otp-display');
        display.textContent = otp.padEnd(6, '-');

        // Visual feedback
        if (otp.length === 6) {
            verifyBtn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
            verifyBtn.classList.add('bg-green-600', 'hover:bg-green-700');
        } else {
            verifyBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
            verifyBtn.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
        }
    }

    // Countdown timer
    let timeLeft = 60;
    const countdown = setInterval(() => {
        timerEl.textContent = timeLeft;
        timeLeft--;
        if (timeLeft < 0) {
            clearInterval(countdown);
            countdownEl.style.display = 'none';
        }
    }, 1000);

    // Form submission
    document.getElementById('otp-form').addEventListener('submit', function(e) {
        const otp = Array.from(otpInputs).map(input => input.value).join('');

        if (otp.length !== 6) {
            e.preventDefault();
            alert('Please enter the complete 6-digit OTP');
            return false;
        }

        // Disable the button to prevent double submission
        verifyBtn.disabled = true;
        verifyBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...';
    });
});
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>