<!-- Create Entry Modal -->
<div id="create-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/20 backdrop-blur-sm" onclick="closeCreateModal()"></div>

    <div id="create-modal-content" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-white/20 p-8 mx-4 animate-modal-appear">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 font-poppins">Create New Entry</h2>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <form id="create-form" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <!-- Title and Date Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 font-poppins">Title</label>
                        <input type="text" name="title" required
                               class="w-full px-4 py-3 bg-white/50 border border-gray-200/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-transparent transition-all duration-200 font-poppins text-sm"
                               placeholder="What's on your mind?">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 font-poppins">Date</label>
                        <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required
                               class="w-full px-4 py-3 bg-white/50 border border-gray-200/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-transparent transition-all duration-200 font-poppins text-sm">
                    </div>
                </div>

                <!-- Mood Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700 font-poppins">How are you feeling?</label>
                    <div class="grid grid-cols-3 gap-3">
                        <button type="button" class="mood-option p-3 rounded-xl border-2 border-gray-200/50 hover:border-pink-300 transition-all duration-200 bg-white/30 hover:bg-white/60" data-mood="Happy">
                            <div class="text-center">
                                <div class="text-2xl mb-1">😊</div>
                                <div class="text-xs font-medium text-gray-700 font-poppins">Happy</div>
                            </div>
                        </button>
                        <button type="button" class="mood-option p-3 rounded-xl border-2 border-gray-200/50 hover:border-pink-300 transition-all duration-200 bg-white/30 hover:bg-white/60" data-mood="Calm">
                            <div class="text-center">
                                <div class="text-2xl mb-1">😌</div>
                                <div class="text-xs font-medium text-gray-700 font-poppins">Calm</div>
                            </div>
                        </button>
                        <button type="button" class="mood-option p-3 rounded-xl border-2 border-gray-200/50 hover:border-pink-300 transition-all duration-200 bg-white/30 hover:bg-white/60" data-mood="Sad">
                            <div class="text-center">
                                <div class="text-2xl mb-1">😢</div>
                                <div class="text-xs font-medium text-gray-700 font-poppins">Sad</div>
                            </div>
                        </button>
                        <button type="button" class="mood-option p-3 rounded-xl border-2 border-gray-200/50 hover:border-pink-300 transition-all duration-200 bg-white/30 hover:bg-white/60" data-mood="Anxious">
                            <div class="text-center">
                                <div class="text-2xl mb-1">😰</div>
                                <div class="text-xs font-medium text-gray-700 font-poppins">Anxious</div>
                            </div>
                        </button>
                        <button type="button" class="mood-option p-3 rounded-xl border-2 border-gray-200/50 hover:border-pink-300 transition-all duration-200 bg-white/30 hover:bg-white/60" data-mood="Excited">
                            <div class="text-center">
                                <div class="text-2xl mb-1">🤩</div>
                                <div class="text-xs font-medium text-gray-700 font-poppins">Excited</div>
                            </div>
                        </button>
                        <button type="button" class="mood-option p-3 rounded-xl border-2 border-gray-200/50 hover:border-pink-300 transition-all duration-200 bg-white/30 hover:bg-white/60" data-mood="Tired">
                            <div class="text-center">
                                <div class="text-2xl mb-1">😴</div>
                                <div class="text-xs font-medium text-gray-700 font-poppins">Tired</div>
                            </div>
                        </button>
                    </div>
                    <input type="hidden" name="mood" id="selected-mood">
                </div>

                <!-- Font Picker -->
                <?php include __DIR__ . '/font_picker.php'; ?>

                <!-- Content -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 font-poppins">Your thoughts</label>
                    <textarea name="content" rows="6" required
                              class="w-full px-4 py-3 bg-white/50 border border-gray-200/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-transparent transition-all duration-200 resize-none font-poppins text-sm"
                              placeholder="Write your story here..."></textarea>
                </div>

                <!-- Images -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700 font-poppins">Add some photos</label>
                    <div id="image-upload-area" class="border-2 border-dashed border-gray-300/50 rounded-xl p-6 text-center bg-white/30 hover:bg-white/50 transition-all duration-200 cursor-pointer">
                        <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-600 font-poppins">Drop photos here or click to browse</p>
                        <p class="text-xs text-gray-500 font-poppins">Up to 5MB per image</p>
                        <input type="file" id="image-input" name="images[]" multiple accept="image/*" class="hidden">
                    </div>
                    <div id="image-previews" class="grid grid-cols-4 gap-3"></div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeCreateModal()"
                            class="px-6 py-2 text-gray-600 hover:text-gray-800 transition-colors font-poppins text-sm">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-6 py-2 bg-gradient-to-r from-pink-400 to-purple-500 hover:from-pink-500 hover:to-purple-600 text-white rounded-xl transition-all duration-200 font-poppins text-sm shadow-sm hover:shadow-md">
                        Create Entry
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let selectedMood = '';

function openCreateModal() {
    const modal = document.getElementById('create-modal');
    const content = document.getElementById('create-modal-content');

    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.add('animate-modal-appear');
    }, 10);
}

function closeCreateModal() {
    const modal = document.getElementById('create-modal');
    const content = document.getElementById('create-modal-content');

    content.classList.remove('animate-modal-appear');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

// Mood selection
document.addEventListener('click', function(e) {
    if (e.target.closest('.mood-option')) {
        const button = e.target.closest('.mood-option');
        const mood = button.dataset.mood;

        // Remove selected class from all buttons
        document.querySelectorAll('.mood-option').forEach(btn => {
            btn.classList.remove('border-pink-400', 'bg-pink-100/50');
            btn.classList.add('border-gray-200/50', 'bg-white/30');
        });

        // Add selected class to clicked button
        button.classList.remove('border-gray-200/50', 'bg-white/30');
        button.classList.add('border-pink-400', 'bg-pink-100/50');

        selectedMood = mood;
        document.getElementById('selected-mood').value = mood;
    }
});

// Image upload
document.getElementById('image-upload-area').addEventListener('click', () => {
    document.getElementById('image-input').click();
});

document.getElementById('image-input').addEventListener('change', handleImageSelection);

function handleImageSelection(e) {
    const files = Array.from(e.target.files);
    const previews = document.getElementById('image-previews');

    files.forEach(file => {
        if (file.type.startsWith('image/') && file.size <= 5242880) { // 5MB
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('div');
                preview.className = 'relative group';
                preview.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-20 object-cover rounded-lg border-2 border-white shadow-sm">
                    <button type="button" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs" onclick="removeImage(this)">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                previews.appendChild(preview);
            };
            reader.readAsDataURL(file);
        }
    });
}

function removeImage(button) {
    button.closest('.relative').remove();
}

// Form submission
document.getElementById('create-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('<?php echo APP_URL; ?>/diary/create', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.redirected) {
            // Successful creation - redirected to diary page
            closeCreateModal();
            location.reload();
        } else {
            // Check if it's an error response
            return response.text().then(text => {
                if (text.includes('error') || response.status !== 200) {
                    throw new Error('Failed to create entry');
                }
            });
        }
    })
    .catch(error => {
        showToast('Failed to create entry', 'error');
        console.error('Error:', error);
    });
});
</script>