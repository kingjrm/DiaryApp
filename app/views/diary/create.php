<?php
$title = 'Create New Entry';
include __DIR__ . '/../components/header.php';
include __DIR__ . '/../components/navbar.php';
?>

<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="glass rounded-xl p-8 neumorphism">
        <h1 class="text-2xl font-bold text-gray-900 mb-8">Create New Diary Entry</h1>

        <form id="diary-form" action="<?php echo APP_URL; ?>/diary/create" method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-xs font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" id="title" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset" placeholder="Enter entry title">
                </div>
                <div>
                    <label for="date" class="block text-xs font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" id="date" name="date" value="<?php echo $_GET['date'] ?? date('Y-m-d'); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset">
                </div>
            </div>

            <div>
                <label for="mood" class="block text-xs font-medium text-gray-700 mb-2">Mood (Optional)</label>
                <select id="mood" name="mood" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset">
                    <option value="">Select mood</option>
                    <option value="Happy">😊 Happy</option>
                    <option value="Sad">😢 Sad</option>
                    <option value="Excited">🤩 Excited</option>
                    <option value="Angry">😠 Angry</option>
                    <option value="Calm">😌 Calm</option>
                    <option value="Anxious">😰 Anxious</option>
                    <option value="Grateful">🙏 Grateful</option>
                    <option value="Tired">😴 Tired</option>
                    <option value="Confused">😕 Confused</option>
                </select>
            </div>

            <div>
                <label for="content" class="block text-xs font-medium text-gray-700 mb-2">Content</label>
                <textarea id="content" name="content" rows="10" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset resize-none" placeholder="Write your thoughts here..."></textarea>
                <div class="text-xs text-gray-500 mt-1">Auto-saved every 30 seconds</div>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-2">Images (Optional)</label>
                <div id="image-upload" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-400 transition-colors cursor-pointer neumorphism-inset">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600">Drag & drop images here or click to browse</p>
                    <p class="text-xs text-gray-500">Max 5MB per image, JPG/PNG/GIF only</p>
                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                </div>
                <div id="image-preview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="<?php echo APP_URL; ?>/diary" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors flex items-center">
                    <i class="fas fa-save mr-2"></i>Save Entry
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('diary-form');
    const contentTextarea = document.getElementById('content');
    const imageUpload = document.getElementById('image-upload');
    const imageInput = document.getElementById('images');
    const imagePreview = document.getElementById('image-preview');

    // Auto-save functionality
    let autoSaveTimer;
    contentTextarea.addEventListener('input', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(autoSave, 30000);
    });

    function autoSave() {
        const formData = new FormData();
        formData.append('content', contentTextarea.value);
        formData.append('title', document.getElementById('title').value);
        formData.append('date', document.getElementById('date').value);
        formData.append('mood', document.getElementById('mood').value);

        fetch('<?php echo APP_URL; ?>/api/autosave', {
            method: 'POST',
            body: formData
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Auto-saved', 'success');
            }
        });
    }

    // Image upload handling
    imageUpload.addEventListener('click', () => imageInput.click());
    imageUpload.addEventListener('dragover', (e) => {
        e.preventDefault();
        imageUpload.classList.add('border-indigo-500');
    });
    imageUpload.addEventListener('dragleave', () => {
        imageUpload.classList.remove('border-indigo-500');
    });
    imageUpload.addEventListener('drop', (e) => {
        e.preventDefault();
        imageUpload.classList.remove('border-indigo-500');
        const files = Array.from(e.dataTransfer.files);
        handleFiles(files);
    });

    imageInput.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);
        handleFiles(files);
    });

    function handleFiles(files) {
        files.forEach(file => {
            if (file.type.startsWith('image/') && file.size <= 5242880) { // 5MB
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'relative group';
                    previewDiv.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg">
                        <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity" onclick="removeImage(this)">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    `;
                    imagePreview.appendChild(previewDiv);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    window.removeImage = function(button) {
        button.closest('.relative').remove();
    };

    // Form validation
    form.addEventListener('submit', function(e) {
        const title = document.getElementById('title').value.trim();
        const content = contentTextarea.value.trim();

        if (!title || !content) {
            e.preventDefault();
            showToast('Please fill in all required fields', 'error');
        }
    });
});
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>