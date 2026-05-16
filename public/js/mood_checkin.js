document.addEventListener('DOMContentLoaded', function() {
    const moodModal = document.getElementById('mood-modal');
    const moodModalContent = document.getElementById('mood-modal-content');
    const moodButtons = document.querySelectorAll('.mood-btn');
    const submitBtn = document.getElementById('submit-mood');
    const skipBtn = document.getElementById('skip-mood');
    const noteTextarea = document.getElementById('mood-note');

    let selectedMood = null;

    if (!moodModal) return;

    // Show modal with animation if needed
    if (!moodModal.classList.contains('hidden')) {
        setTimeout(() => {
            if (moodModalContent) {
                moodModalContent.classList.remove('scale-95', 'opacity-0');
                moodModalContent.classList.add('scale-100', 'opacity-100');
            }
        }, 100);
    }

    // Mood selection
    moodButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove previous selection
            moodButtons.forEach(btn => {
                btn.classList.remove('border-blue-500', 'bg-blue-50', 'ring-2', 'ring-blue-200');
                btn.classList.add('border-gray-200');
            });

            // Select current mood
            this.classList.remove('border-gray-200');
            this.classList.add('border-blue-500', 'bg-blue-50', 'ring-2', 'ring-blue-200');
            selectedMood = this.dataset.mood;

            // Enable submit button
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');
            }

            // Add subtle animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });

    // Submit mood
    if (submitBtn) {
        submitBtn.addEventListener('click', async function() {
            if (!selectedMood) return;

            const note = noteTextarea ? noteTextarea.value.trim() : '';

            try {
                const response = await fetch(window.APP_CONFIG.url + '/api/submit-mood', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        mood: selectedMood,
                        note: note,
                        csrf_token: window.APP_CONFIG.csrfToken
                    })
                });

                const result = await response.json();

                if (result.success) {
                    // Success animation
                    if (moodModalContent) moodModalContent.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        moodModal.classList.add('hidden');
                        // Show success message
                        if (typeof showToast === 'function') {
                            showToast('Mood recorded! Thank you for sharing.', 'success');
                        }
                    }, 200);
                } else {
                    if (typeof showToast === 'function') {
                        showToast(result.message || 'Failed to save mood', 'error');
                    }
                }
            } catch (error) {
                if (typeof showToast === 'function') {
                    showToast('Network error. Please try again.', 'error');
                }
            }
        });
    }

    // Skip mood check-in
    if (skipBtn) {
        skipBtn.addEventListener('click', function() {
            if (moodModalContent) moodModalContent.style.transform = 'scale(0.95)';
            setTimeout(() => {
                moodModal.classList.add('hidden');
            }, 200);
        });
    }

    // Close on backdrop click
    moodModal.addEventListener('click', function(e) {
        if (e.target === moodModal) {
            if (moodModalContent) moodModalContent.style.transform = 'scale(0.95)';
            setTimeout(() => {
                moodModal.classList.add('hidden');
            }, 200);
        }
    });
});

if (typeof window.showToast !== 'function') {
    window.showToast = function(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 px-4 py-2 rounded-lg text-sm font-medium z-50 transition-all duration-300 transform translate-x-full`;
        toast.style.fontFamily = "'Poppins', sans-serif";

        if (type === 'success') {
            toast.classList.add('bg-green-500', 'text-white');
        } else if (type === 'error') {
            toast.classList.add('bg-red-500', 'text-white');
        } else {
            toast.classList.add('bg-blue-500', 'text-white');
        }

        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);

        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                if(document.body.contains(toast)) {
                    document.body.removeChild(toast);
                }
            }, 300);
        }, 3000);
    };
}
