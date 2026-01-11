<?php
$title = 'Create New Entry';
include __DIR__ . '/../components/header.php';
include __DIR__ . '/../components/navbar.php';
?>

<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="glass rounded-xl p-8 neumorphism">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 font-poppins">Create New Diary Entry</h1>
            <p class="text-sm text-gray-600 mt-1">Capture your thoughts and memories</p>
        </div>

        <form id="diary-form" action="<?php echo APP_URL; ?>/diary/create" method="POST" enctype="multipart/form-data" class="space-y-8">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <!-- Basic Information Section -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-100">
                <div class="flex items-center mb-4">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Basic Information</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-heading text-gray-400 mr-1"></i>Title
                        </label>
                        <input type="text" id="title" name="title" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent neumorphism-inset font-poppins"
                               placeholder="Give your entry a meaningful title">
                    </div>

                    <div class="space-y-2">
                        <label for="date" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-calendar text-gray-400 mr-1"></i>Date
                        </label>
                        <input type="date" id="date" name="date" value="<?php echo $_GET['date'] ?? date('Y-m-d'); ?>" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent neumorphism-inset">
                    </div>
                </div>

                <div class="mt-6 space-y-2">
                    <label for="mood" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-smile text-gray-400 mr-1"></i>Mood (Optional)
                    </label>
                    <select id="mood" name="mood"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent neumorphism-inset appearance-none">
                        <option value="">Select your mood</option>
                        <option value="Happy">😊 Happy</option>
                        <option value="Calm">😌 Calm</option>
                        <option value="Sad">😢 Sad</option>
                        <option value="Anxious">😰 Anxious</option>
                        <option value="Excited">🤩 Excited</option>
                        <option value="Tired">😴 Tired</option>
                        <option value="Angry">😠 Angry</option>
                        <option value="Loved">🥰 Loved</option>
                    </select>
                </div>
            </div>

            <!-- Typography Section -->
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-6 border border-purple-100">
                <div class="flex items-center mb-4">
                    <i class="fas fa-font text-purple-500 mr-3"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Typography</h2>
                </div>
                <?php include __DIR__ . '/../components/font_picker.php'; ?>
            </div>

            <!-- Card Customization Section -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-6 border border-green-100">
                <div class="flex items-center mb-6">
                    <i class="fas fa-palette text-green-500 mr-3"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Card Customization</h2>
                    <span class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">Make it unique!</span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Background Options -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-800 flex items-center">
                            <i class="fas fa-image text-gray-500 mr-2"></i>Background
                        </h3>

                        <div class="bg-white rounded-lg p-4 border border-gray-200 neumorphism">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Solid Color</label>
                                    <div class="flex items-center space-x-3">
                                        <input type="color" id="background_color" name="background_color" value="#ffffff"
                                               class="w-12 h-10 border border-gray-300 rounded-md neumorphism-inset cursor-pointer">
                                        <input type="text" readonly value="#ffffff"
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-sm font-mono">
                                    </div>
                                </div>

                                <div class="border-t pt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Or Upload Background Image</label>
                                    <input type="file" id="background_image" name="background_image" accept="image/*"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md neumorphism-inset file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF up to 5MB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Text Styling Options -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-800 flex items-center">
                            <i class="fas fa-text-width text-gray-500 mr-2"></i>Text Styling
                        </h3>

                        <div class="bg-white rounded-lg p-4 border border-gray-200 neumorphism">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Text Color</label>
                                    <div class="flex items-center space-x-3">
                                        <input type="color" id="text_color" name="text_color" value="#000000"
                                               class="w-12 h-10 border border-gray-300 rounded-md neumorphism-inset cursor-pointer">
                                        <input type="text" readonly value="#000000"
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-sm font-mono">
                                    </div>
                                </div>

                                <div class="border-t pt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Text Formatting</label>
                                    <div class="grid grid-cols-1 gap-3">
                                        <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                            <input type="checkbox" id="text_bold" name="text_bold" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                            <span class="ml-3 text-sm font-bold">Bold Text</span>
                                            <span class="ml-auto text-xs text-gray-500 bg-white px-2 py-1 rounded">B</span>
                                        </label>

                                        <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                            <input type="checkbox" id="text_italic" name="text_italic" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                            <span class="ml-3 text-sm italic">Italic Text</span>
                                            <span class="ml-auto text-xs text-gray-500 bg-white px-2 py-1 rounded italic">I</span>
                                        </label>

                                        <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                            <input type="checkbox" id="text_underline" name="text_underline" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                            <span class="ml-3 text-sm underline">Underlined Text</span>
                                            <span class="ml-auto text-xs text-gray-500 bg-white px-2 py-1 rounded underline">U</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg p-6 border border-yellow-100">
                <div class="flex items-center mb-4">
                    <i class="fas fa-edit text-yellow-500 mr-3"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Your Story</h2>
                </div>

                <div class="space-y-2">
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea id="content" name="content" rows="12" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent neumorphism-inset resize-none font-poppins"
                              placeholder="Pour your heart out..."></textarea>
                    <div class="text-xs text-gray-500 flex items-center">
                        <i class="fas fa-info-circle mr-1"></i>
                        Auto-saved every 30 seconds
                    </div>
                </div>
            </div>

            <!-- Images Section -->
            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg p-6 border border-indigo-100">
                <div class="flex items-center mb-4">
                    <i class="fas fa-plus-circle text-indigo-500 mr-3"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Add Images</h2>
                    <span class="ml-2 text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full">Optional</span>
                </div>

                <div id="image-upload"
                     class="border-2 border-dashed border-indigo-300 rounded-lg p-8 text-center hover:border-indigo-400 hover:bg-indigo-50 transition-all duration-200 cursor-pointer neumorphism-inset">
                    <i class="fas fa-cloud-upload-alt text-4xl text-indigo-400 mb-3"></i>
                    <p class="text-lg font-medium text-gray-700 mb-1">Drag & drop images here</p>
                    <p class="text-sm text-gray-500">or click to browse your files</p>
                    <p class="text-xs text-gray-400 mt-2">Max 5MB per image, JPG/PNG/GIF only</p>
                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                </div>
                <div id="image-preview" class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                <a href="<?php echo APP_URL; ?>/diary"
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors flex items-center justify-center font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Diary
                </a>
                <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg transition-all duration-200 flex items-center justify-center font-medium shadow-sm hover:shadow-md transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>Create Entry
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

    // Color picker synchronization
    const backgroundColorInput = document.getElementById('background_color');
    const backgroundColorText = backgroundColorInput.nextElementSibling;
    const textColorInput = document.getElementById('text_color');
    const textColorText = textColorInput.nextElementSibling;

    backgroundColorInput.addEventListener('input', function() {
        backgroundColorText.value = this.value;
    });

    textColorInput.addEventListener('input', function() {
        textColorText.value = this.value;
    });

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
        imageUpload.classList.add('border-indigo-500', 'bg-indigo-100');
    });
    imageUpload.addEventListener('dragleave', () => {
        imageUpload.classList.remove('border-indigo-500', 'bg-indigo-100');
    });
    imageUpload.addEventListener('drop', (e) => {
        e.preventDefault();
        imageUpload.classList.remove('border-indigo-500', 'bg-indigo-100');
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
                    previewDiv.className = 'relative group bg-white rounded-lg overflow-hidden border border-gray-200 neumorphism';
                    previewDiv.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-200 flex items-center justify-center">
                            <button type="button" class="opacity-0 group-hover:opacity-100 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center transition-all duration-200" onclick="removeImage(this)">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-1">
                            <p class="text-xs text-white opacity-75">${file.name}</p>
                        </div>
                    `;
                    imagePreview.appendChild(previewDiv);
                };
                reader.readAsDataURL(file);
            } else {
                showToast('Invalid file: ' + file.name + ' (must be image, max 5MB)', 'error');
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