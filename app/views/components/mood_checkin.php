<!-- Daily Mood Check-In Modal -->
<div id="mood-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 <?php echo isset($_SESSION['show_mood_checkin']) ? '' : 'hidden'; ?>">
    <div class="mood-card max-w-md w-full mx-4 p-8 relative page-flip" id="mood-modal-content">
        <!-- Tape corners -->
        <div class="tape-corner tl"></div>
        <div class="tape-corner tr"></div>
        <div class="tape-corner bl"></div>
        <div class="tape-corner br"></div>

        <!-- Floating stickers -->
        <div class="absolute -top-4 -right-4 sticker">🌟</div>
        <div class="absolute -bottom-4 -left-4 sticker">✨</div>
        <div class="absolute top-1/2 -right-6 sticker">💖</div>

        <!-- Header -->
        <div class="text-center mb-6 relative z-10">
            <div class="w-16 h-16 bg-gradient-to-br from-pink-300 to-purple-400 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg sticker">
                <i class="fas fa-heart text-white text-2xl"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2 font-dancing">How are you feeling today?</h2>
            <p class="text-sm text-gray-600 font-poppins">Take a moment to check in with yourself</p>
        </div>

        <!-- Mood Selection -->
        <div class="grid grid-cols-2 gap-3 mb-6 relative z-10">
            <button class="mood-btn flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-pink-300 transition-all duration-200 transform hover:scale-105 bg-white/80 backdrop-blur-sm" data-mood="Happy">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mb-2 shadow-md">
                    <span class="text-2xl">😊</span>
                </div>
                <span class="text-xs font-medium text-gray-700 font-poppins">Happy</span>
            </button>

            <button class="mood-btn flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-pink-300 transition-all duration-200 transform hover:scale-105 bg-white/80 backdrop-blur-sm" data-mood="Calm">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-2 shadow-md">
                    <span class="text-2xl">😌</span>
                </div>
                <span class="text-xs font-medium text-gray-700 font-poppins">Calm</span>
            </button>

            <button class="mood-btn flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-pink-300 transition-all duration-200 transform hover:scale-105 bg-white/80 backdrop-blur-sm" data-mood="Sad">
                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-2 shadow-md">
                    <span class="text-2xl">😢</span>
                </div>
                <span class="text-xs font-medium text-gray-700 font-poppins">Sad</span>
            </button>

            <button class="mood-btn flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-pink-300 transition-all duration-200 transform hover:scale-105 bg-white/80 backdrop-blur-sm" data-mood="Anxious">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-2 shadow-md">
                    <span class="text-2xl">😰</span>
                </div>
                <span class="text-xs font-medium text-gray-700 font-poppins">Anxious</span>
            </button>

            <button class="mood-btn flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-pink-300 transition-all duration-200 transform hover:scale-105 bg-white/80 backdrop-blur-sm" data-mood="Excited">
                <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center mb-2 shadow-md">
                    <span class="text-2xl">🤩</span>
                </div>
                <span class="text-xs font-medium text-gray-700 font-poppins">Excited</span>
            </button>

            <button class="mood-btn flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-pink-300 transition-all duration-200 transform hover:scale-105 bg-white/80 backdrop-blur-sm" data-mood="Tired">
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mb-2 shadow-md">
                    <span class="text-2xl">😴</span>
                </div>
                <span class="text-xs font-medium text-gray-700 font-poppins">Tired</span>
            </button>

            <button class="mood-btn flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-pink-300 transition-all duration-200 transform hover:scale-105 bg-white/80 backdrop-blur-sm" data-mood="Angry">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-2 shadow-md">
                    <span class="text-2xl">😠</span>
                </div>
                <span class="text-xs font-medium text-gray-700 font-poppins">Angry</span>
            </button>

            <button class="mood-btn flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-pink-300 transition-all duration-200 transform hover:scale-105 bg-white/80 backdrop-blur-sm" data-mood="Loved">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-2 shadow-md">
                    <span class="text-2xl">🥰</span>
                </div>
                <span class="text-xs font-medium text-gray-700 font-poppins">Loved</span>
            </button>
        </div>

        <!-- Optional Note -->
        <div class="mb-6">
            <label for="mood-note" class="block text-xs font-medium text-gray-700 mb-2 font-poppins">Anything you'd like to share? (Optional)</label>
            <textarea id="mood-note" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-transparent resize-none text-sm font-poppins" placeholder="How are you feeling? What's on your mind?"></textarea>
        </div>

        <!-- Actions -->
        <div class="flex space-x-3 relative z-10">
            <button id="skip-mood" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium font-poppins">
                Skip for now
            </button>
            <button id="submit-mood" class="flex-1 px-4 py-2 bg-gradient-to-r from-pink-400 to-purple-500 hover:from-pink-500 hover:to-purple-600 text-white rounded-lg transition-all duration-200 text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed font-poppins transform hover:scale-105" disabled>
                Share Mood ✨
            </button>
        </div>

        <!-- Floating Decorative Elements -->
        <div class="absolute top-4 right-4 text-2xl animate-bounce" style="animation-delay: 0s;">🌸</div>
        <div class="absolute bottom-4 left-4 text-xl animate-bounce" style="animation-delay: 1s;">⭐</div>
        <div class="absolute top-1/2 right-2 text-lg animate-bounce" style="animation-delay: 2s;">💖</div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const moodModal = document.getElementById('mood-modal');
    const moodModalContent = document.getElementById('mood-modal-content');
    const moodButtons = document.querySelectorAll('.mood-btn');
    const submitBtn = document.getElementById('submit-mood');
    const skipBtn = document.getElementById('skip-mood');
    const noteTextarea = document.getElementById('mood-note');

    let selectedMood = null;

    // Show modal with animation if needed
    if (moodModal && !moodModal.classList.contains('hidden')) {
        setTimeout(() => {
            moodModalContent.classList.remove('scale-95', 'opacity-0');
            moodModalContent.classList.add('scale-100', 'opacity-100');
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
            submitBtn.disabled = false;
            submitBtn.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');

            // Add subtle animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });

    // Submit mood
    submitBtn.addEventListener('click', async function() {
        if (!selectedMood) return;

        const note = noteTextarea.value.trim();

        try {
            const response = await fetch('<?php echo APP_URL; ?>/api/submit-mood', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    mood: selectedMood,
                    note: note,
                    csrf_token: '<?php echo $_SESSION['csrf_token'] ?? ''; ?>'
                })
            });

            const result = await response.json();

            if (result.success) {
                // Success animation
                moodModalContent.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    moodModal.classList.add('hidden');
                    // Show success message
                    showToast('Mood recorded! Thank you for sharing.', 'success');
                }, 200);
            } else {
                showToast(result.message || 'Failed to save mood', 'error');
            }
        } catch (error) {
            showToast('Network error. Please try again.', 'error');
        }
    });

    // Skip mood check-in
    skipBtn.addEventListener('click', function() {
        moodModalContent.style.transform = 'scale(0.95)';
        setTimeout(() => {
            moodModal.classList.add('hidden');
        }, 200);
    });

    // Close on backdrop click
    moodModal.addEventListener('click', function(e) {
        if (e.target === moodModal) {
            moodModalContent.style.transform = 'scale(0.95)';
            setTimeout(() => {
                moodModal.classList.add('hidden');
            }, 200);
        }
    });
});

// Toast notification function (assuming it exists)
function showToast(message, type = 'info') {
    // Create toast element
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

    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);

    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}
</script>