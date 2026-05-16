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
            verifyBtn.classList.add('verified');
        } else {
            verifyBtn.classList.remove('verified');
        }
    }

    // Countdown timer
    let timeLeft = 60;
    if (timerEl && countdownEl) {
        const countdown = setInterval(() => {
            timerEl.textContent = timeLeft;
            timeLeft--;
            if (timeLeft < 0) {
                clearInterval(countdown);
                countdownEl.style.display = 'none';
            }
        }, 1000);
    }

    // Form submission
    const otpForm = document.getElementById('otp-form');
    if (otpForm) {
        otpForm.addEventListener('submit', function(e) {
            const otp = Array.from(otpInputs).map(input => input.value).join('');

            if (otp.length !== 6) {
                e.preventDefault();
                alert('Please enter the complete 6-digit OTP');
                return false;
            }

            // Set the hidden otp field
            document.getElementById('otp').value = otp;

            // Disable the button to prevent double submission
            verifyBtn.disabled = true;
            verifyBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Verifying...';
        });
    }
});
