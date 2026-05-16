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

document.addEventListener('DOMContentLoaded', function() {
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
    const imageUploadArea = document.getElementById('image-upload-area');
    const imageInput = document.getElementById('image-input');
    const imagePreviews = document.getElementById('image-previews');

    if (imageUploadArea && imageInput && imagePreviews) {
        imageUploadArea.addEventListener('click', () => {
            imageInput.click();
        });

        imageUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            imageUploadArea.classList.add('border-pink-400', 'bg-pink-100/50');
        });

        imageUploadArea.addEventListener('dragleave', () => {
            imageUploadArea.classList.remove('border-pink-400', 'bg-pink-100/50');
        });

        imageUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            imageUploadArea.classList.remove('border-pink-400', 'bg-pink-100/50');
            const files = Array.from(e.dataTransfer.files);
            handleImageSelection(files);
        });

        imageInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files);
            handleImageSelection(files);
        });

        function handleImageSelection(files) {
            // Create a DataTransfer object to update the file input
            const dt = new DataTransfer();
            
            // Add existing files from input
            if (imageInput.files) {
                Array.from(imageInput.files).forEach(file => dt.items.add(file));
            }
            
            files.forEach(file => {
                if (file.type.startsWith('image/') && file.size <= 5242880) { // 5MB
                    dt.items.add(file);
                    
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
                        imagePreviews.appendChild(preview);
                    };
                    reader.readAsDataURL(file);
                } else {
                    if (typeof showToast === 'function') {
                        showToast('Invalid file: ' + file.name + ' (must be image, max 5MB)', 'error');
                    } else {
                        alert('Invalid file: ' + file.name + ' (must be image, max 5MB)');
                    }
                }
            });
            
            // Update the file input with the new files
            imageInput.files = dt.files;
        }

        window.removeImage = function(button) {
            button.closest('.relative').remove();
            
            const dt = new DataTransfer();
            imageInput.files = dt.files;
        };
    }

    // Form submission
    const createForm = document.getElementById('create-form');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(window.APP_CONFIG.url + '/diary/create', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok && response.redirected) {
                    closeCreateModal();
                    location.reload();
                } else if (response.redirected) {
                    closeCreateModal();
                    location.reload();
                } else {
                    return response.text().then(text => {
                        if (text.includes('error') || response.status !== 200) {
                            throw new Error('Failed to create entry');
                        }
                    });
                }
            })
            .catch(error => {
                if (typeof showToast === 'function') showToast('Failed to create entry', 'error');
                console.error('Error:', error);
            });
        });
    }
});
