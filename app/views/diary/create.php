<?php
$title = 'Create New Entry';
include __DIR__ . '/../components/header.php';
include __DIR__ . '/../components/diary_header.php';
include __DIR__ . '/../components/sidebar.php';
?>

<div class="pt-16 pb-8 min-h-screen bg-gray-50">
    <div class="md:ml-72">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 font-poppins">Write Entry</h1>
                    <p class="text-sm text-gray-500 mt-1 font-poppins">Capture your thoughts for today</p>
                </div>
                <a href="<?php echo url('diary'); ?>" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors bg-white px-4 py-2 border border-gray-200 rounded-lg shadow-sm">
                    <i class="fas fa-times mr-1"></i> Cancel
                </a>
            </div>

            <form id="diary-form" action="<?php echo url('diary/create'); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div class="flex flex-col lg:flex-row gap-6">
                    
                    <!-- LEFT COLUMN: EDITOR -->
                    <div class="w-full lg:w-2/3 flex flex-col gap-6">
                        
                        <!-- Main Editor Card -->
                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden flex flex-col flex-1 min-h-[400px]">
                            
                            <!-- Top Bar: Title & Date -->
                            <div class="flex flex-col sm:flex-row border-b border-gray-100">
                                <input type="text" id="title" name="title" required
                                       class="flex-1 px-6 py-5 text-xl font-bold text-gray-800 placeholder-gray-300 border-none focus:outline-none focus:ring-0 font-poppins bg-transparent"
                                       placeholder="Entry Title">
                                
                                <div class="px-6 py-5 sm:border-l border-gray-100 flex items-center bg-gray-50/50">
                                    <i class="fas fa-calendar text-gray-400 mr-3 text-sm"></i>
                                    <input type="date" id="date" name="date" value="<?php echo $_GET['date'] ?? date('Y-m-d'); ?>" required
                                           class="text-sm font-medium text-gray-600 bg-transparent border-none focus:outline-none focus:ring-0 cursor-pointer">
                                </div>
                            </div>

                            <!-- Content Area -->
                            <div class="flex-1 flex flex-col relative">
                                <textarea id="content" name="content" required
                                          class="flex-1 w-full px-6 py-6 text-gray-700 placeholder-gray-300 border-none focus:outline-none focus:ring-0 resize-none font-poppins leading-relaxed bg-transparent"
                                          placeholder="Start writing..."></textarea>
                                
                                <!-- Image Preview Area (Hidden if empty) -->
                                <div id="image-preview" class="px-6 pb-4 grid grid-cols-2 md:grid-cols-4 gap-4 empty:hidden"></div>
                            </div>

                            <!-- Toolbar -->
                            <div class="bg-gray-50 border-t border-gray-200 px-4 py-3 flex flex-wrap items-center justify-between gap-4">
                                <div class="flex items-center space-x-4">
                                    <!-- Mood -->
                                    <div class="relative group">
                                        <select id="mood" name="mood"
                                                class="appearance-none bg-white border border-gray-200 text-gray-600 text-sm rounded-lg px-3 py-1.5 focus:outline-none focus:border-gray-400 cursor-pointer hover:bg-gray-50 pr-8 transition-colors">
                                            <option value="">No Mood</option>
                                            <option value="Happy">😊 Happy</option>
                                            <option value="Calm">😌 Calm</option>
                                            <option value="Sad">😢 Sad</option>
                                            <option value="Anxious">😰 Anxious</option>
                                            <option value="Excited">🤩 Excited</option>
                                            <option value="Tired">😴 Tired</option>
                                            <option value="Angry">😠 Angry</option>
                                            <option value="Loved">🥰 Loved</option>
                                        </select>
                                        <i class="fas fa-chevron-down absolute right-2.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                                    </div>
                                    
                                    <div class="h-4 w-px bg-gray-300"></div>
                                    
                                    <!-- Image Upload -->
                                    <button type="button" id="image-upload-btn" class="w-8 h-8 rounded hover:bg-gray-200 flex items-center justify-center text-gray-500 transition-colors" title="Add Image">
                                        <i class="fas fa-image text-sm"></i>
                                    </button>
                                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                                </div>
                                
                                <span class="text-xs text-gray-400 font-medium hidden sm:inline-block"><i class="fas fa-check-circle mr-1"></i>Auto-saves</span>
                            </div>
                        </div>

                        <!-- Customization Section -->
                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 font-poppins border-b border-gray-100 pb-2">Styling Options</h3>
                            
                            <!-- Font Picker Component -->
                            <?php include __DIR__ . '/../components/font_picker.php'; ?>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
                                <!-- Background Options -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Card Background</label>
                                    <div class="space-y-4">
                                        <div class="flex items-center space-x-3">
                                            <input type="color" id="background_color" name="background_color" value="#ffffff"
                                                   class="w-10 h-10 border border-gray-200 rounded-lg cursor-pointer p-0 bg-white shadow-sm">
                                            <span class="text-sm text-gray-600">Solid Color</span>
                                        </div>
                                        <div class="border-t border-gray-100 pt-3">
                                            <label class="block text-xs font-medium text-gray-500 mb-2 uppercase tracking-wider">Or Image Background</label>
                                            <input type="file" id="background_image" name="background_image" accept="image/*"
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition-colors cursor-pointer border border-gray-200 rounded-full bg-white p-1">
                                            <button type="button" id="clear_bg_image" class="hidden mt-2 text-xs text-red-500 hover:text-red-700"><i class="fas fa-times mr-1"></i>Clear Background Image</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Text Options -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Text Styling</label>
                                    <div class="space-y-4">
                                        <div class="flex items-center space-x-3">
                                            <input type="color" id="text_color" name="text_color" value="#000000"
                                                   class="w-10 h-10 border border-gray-200 rounded-lg cursor-pointer p-0 bg-white shadow-sm">
                                            <span class="text-sm text-gray-600">Text Color</span>
                                        </div>
                                        
                                        <div class="border-t border-gray-100 pt-3 flex items-center space-x-3">
                                            <label class="w-10 h-10 rounded-lg bg-gray-50 border border-gray-200 hover:bg-gray-100 flex items-center justify-center text-gray-600 transition-colors cursor-pointer select-none" title="Bold">
                                                <input type="checkbox" id="text_bold" name="text_bold" class="sr-only peer">
                                                <i class="fas fa-bold text-sm peer-checked:text-blue-600"></i>
                                            </label>
                                            
                                            <label class="w-10 h-10 rounded-lg bg-gray-50 border border-gray-200 hover:bg-gray-100 flex items-center justify-center text-gray-600 transition-colors cursor-pointer select-none" title="Italic">
                                                <input type="checkbox" id="text_italic" name="text_italic" class="sr-only peer">
                                                <i class="fas fa-italic text-sm peer-checked:text-blue-600"></i>
                                            </label>

                                            <label class="w-10 h-10 rounded-lg bg-gray-50 border border-gray-200 hover:bg-gray-100 flex items-center justify-center text-gray-600 transition-colors cursor-pointer select-none" title="Underline">
                                                <input type="checkbox" id="text_underline" name="text_underline" class="sr-only peer">
                                                <i class="fas fa-underline text-sm peer-checked:text-blue-600"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <!-- RIGHT COLUMN: LIVE PREVIEW -->
                    <div class="w-full lg:w-1/3">
                        <div class="sticky top-24">
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 flex items-center">
                                <i class="fas fa-eye mr-2"></i> Live Preview
                            </h3>
                            
                            <!-- The Card Container (matching dashboard style) -->
                            <div class="flex justify-center items-start pt-4 pb-8">
                                <div id="preview-card" class="bg-white rounded-lg shadow-lg border-4 border-white relative overflow-hidden transition-all duration-300 w-64 min-h-[120px]" style="background-color: #ffffff;">
                                    
                                    <!-- Tape corners -->
                                    <div class="tape-corner absolute -top-1 -left-1 w-3 h-3 bg-yellow-300 rounded-full shadow-sm"></div>
                                    <div class="tape-corner absolute -top-1 -right-1 w-3 h-3 bg-pink-300 rounded-full shadow-sm"></div>
                                    <div class="tape-corner absolute -bottom-1 -left-1 w-3 h-3 bg-blue-300 rounded-full shadow-sm"></div>
                                    <div class="tape-corner absolute -bottom-1 -right-1 w-3 h-3 bg-green-300 rounded-full shadow-sm"></div>
                                    
                                    <!-- Card Content -->
                                    <div id="preview-content-wrapper" class="p-4 flex flex-col gap-3" style="color: #000000;">
                                        
                                        <!-- Header -->
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1 min-w-0">
                                                <h3 id="preview-title" class="text-sm font-semibold leading-tight truncate">Entry Title</h3>
                                                <p id="preview-date" class="text-xs font-poppins opacity-70"><?php echo date('M j'); ?></p>
                                            </div>
                                        </div>

                                        <!-- Content snippet -->
                                        <div>
                                            <p id="preview-content" class="text-xs leading-relaxed font-poppins break-words line-clamp-6">Start writing...</p>
                                        </div>

                                        <!-- Mood badge -->
                                        <div id="preview-mood-container" class="flex justify-center hidden">
                                            <span id="preview-mood-badge" class="inline-flex items-center px-2 py-1 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full text-xs font-medium shadow-sm gap-1.5 border border-white/50">
                                                <!-- Mood injected here via JS -->
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Save Action -->
                            <div class="mt-6 flex justify-center">
                                <button type="submit"
                                        class="w-full max-w-xs bg-gray-800 hover:bg-gray-900 text-white px-5 py-3 rounded-xl transition-colors flex items-center justify-center font-poppins text-sm font-bold shadow-md">
                                    <i class="fas fa-save mr-2"></i> Save Entry
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Left side elements
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');
    const dateInput = document.getElementById('date');
    const moodSelect = document.getElementById('mood');
    const bgColorInput = document.getElementById('background_color');
    const textColorInput = document.getElementById('text_color');
    const bgImageInput = document.getElementById('background_image');
    const clearBgImageBtn = document.getElementById('clear_bg_image');
    const textBold = document.getElementById('text_bold');
    const textItalic = document.getElementById('text_italic');
    const textUnderline = document.getElementById('text_underline');
    const fontInput = document.getElementById('selected-font'); // from font_picker.php

    // Preview elements
    const pCard = document.getElementById('preview-card');
    const pWrapper = document.getElementById('preview-content-wrapper');
    const pTitle = document.getElementById('preview-title');
    const pDate = document.getElementById('preview-date');
    const pContent = document.getElementById('preview-content');
    const pMoodContainer = document.getElementById('preview-mood-container');
    const pMoodBadge = document.getElementById('preview-mood-badge');

    const moodSvgs = {
        'Happy': '<svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="9" cy="9" r="1.5" fill="currentColor"/><circle cx="15" cy="9" r="1.5" fill="currentColor"/><path d="M9 15c1 1 2 1.5 3 1.5s2-.5 3-1.5" stroke="currentColor" stroke-width="2" fill="none"/></svg>',
        'Calm': '<svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="9" cy="9" r="1.5" fill="currentColor"/><circle cx="15" cy="9" r="1.5" fill="currentColor"/><path d="M9 15h6" stroke="currentColor" stroke-width="2" fill="none"/></svg>',
        'Sad': '<svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="9" cy="9" r="1.5" fill="currentColor"/><circle cx="15" cy="9" r="1.5" fill="currentColor"/><path d="M9 16c1-1 2-1.5 3-1.5s2 .5 3 1.5" stroke="currentColor" stroke-width="2" fill="none"/></svg>',
        'Anxious': '<svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="9" cy="8.5" r="1.5" fill="currentColor"/><circle cx="15" cy="8.5" r="1.5" fill="currentColor"/><path d="M9 15h6M8 11l1-2M15 11l1-2" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>',
        'Excited': '<svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="9" cy="9" r="1.5" fill="currentColor"/><circle cx="15" cy="9" r="1.5" fill="currentColor"/><path d="M8 15c1 2 2.5 3 4 3s3-1 4-3" stroke="currentColor" stroke-width="2" fill="none"/></svg>',
        'Tired': '<svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/><path d="M9 9a2 2 0 00-2 2 2 2 0 002 2 2 2 0 002-2 2 2 0 00-2-2M15 9a2 2 0 00-2 2 2 2 0 002 2 2 2 0 00-2-2" fill="currentColor"/><path d="M9 16h6" stroke="currentColor" stroke-width="2" fill="none"/></svg>',
        'Angry': '<svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/><path d="M8 9l2-1M16 9l-2-1" stroke="currentColor" stroke-width="2" fill="none"/><path d="M9 15h6" stroke="currentColor" stroke-width="2" fill="none"/></svg>',
        'Loved': '<svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/><path d="M9 9a1.5 1.5 0 013 0 1.5 1.5 0 01-3 0M12 9a1.5 1.5 0 013 0 1.5 1.5 0 01-3 0" fill="currentColor"/><path d="M12 17c1.5-1 3-2 3-3" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>'
    };

    function updatePreview() {
        // Text updates
        pTitle.textContent = titleInput.value.trim() || 'Entry Title';
        pContent.textContent = contentInput.value.trim() || 'Start writing...';
        
        // Date format (simple M j)
        if (dateInput.value) {
            const d = new Date(dateInput.value);
            pDate.textContent = d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        }

        // Colors
        pCard.style.backgroundColor = bgColorInput.value;
        pWrapper.style.color = textColorInput.value;

        // Text Styles
        pTitle.style.textDecoration = textUnderline.checked ? 'underline' : 'none';
        pContent.style.textDecoration = textUnderline.checked ? 'underline' : 'none';
        
        if (textBold.checked) {
            pTitle.classList.replace('font-semibold', 'font-bold');
            pContent.style.fontWeight = 'bold';
        } else {
            pTitle.classList.replace('font-bold', 'font-semibold');
            pContent.style.fontWeight = 'normal';
        }
        
        pContent.style.fontStyle = textItalic.checked ? 'italic' : 'normal';

        // Font Family
        if (fontInput) {
            // Remove existing font classes
            pContent.className = pContent.className.replace(/font-\w+/g, '');
            pContent.classList.add(fontInput.value || 'font-poppins');
        }

        // Mood
        if (moodSelect.value) {
            pMoodContainer.classList.remove('hidden');
            const svg = moodSvgs[moodSelect.value] || '';
            pMoodBadge.innerHTML = svg + ' ' + moodSelect.value;
            pMoodBadge.style.color = textColorInput.value;
        } else {
            pMoodContainer.classList.add('hidden');
        }
    }

    // Attach listeners
    const inputs = [titleInput, contentInput, dateInput, moodSelect, bgColorInput, textColorInput, textBold, textItalic, textUnderline];
    inputs.forEach(el => el.addEventListener('input', updatePreview));
    inputs.forEach(el => el.addEventListener('change', updatePreview));

    // Handle Background Image preview
    bgImageInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                pCard.style.backgroundImage = `url('${e.target.result}')`;
                pCard.style.backgroundSize = 'cover';
                pCard.style.backgroundPosition = 'center';
                clearBgImageBtn.classList.remove('hidden');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    clearBgImageBtn.addEventListener('click', function() {
        bgImageInput.value = ''; // clear file
        pCard.style.backgroundImage = 'none';
        clearBgImageBtn.classList.add('hidden');
    });

    // Handle Font selection from font_picker.php
    // The font picker uses onclick="selectFont('font-class')", which updates #selected-font
    // We need to intercept that to update preview
    const observer = new MutationObserver(updatePreview);
    if(fontInput) {
        observer.observe(fontInput, { attributes: true, attributeFilter: ['value'] });
    }
    
    // Fallback: listen to clicks on font options
    document.querySelectorAll('.font-option').forEach(opt => {
        opt.addEventListener('click', () => setTimeout(updatePreview, 50));
    });

    // Initialize
    updatePreview();

    // Normal Images upload (thumbnail generation for UI)
    const imageUploadBtn = document.getElementById('image-upload-btn');
    const imageInput = document.getElementById('images');
    const imagePreviewArea = document.getElementById('image-preview');

    imageUploadBtn.addEventListener('click', () => imageInput.click());
    
    imageInput.addEventListener('change', (e) => {
        const dt = new DataTransfer();
        if (imageInput.files) {
            Array.from(imageInput.files).forEach(file => dt.items.add(file));
        }
        
        Array.from(e.target.files).forEach(file => {
            if (file.type.startsWith('image/') && file.size <= 5242880) { // 5MB
                dt.items.add(file);
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group bg-white rounded-lg overflow-hidden border border-gray-200';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-20 object-cover">
                        <button type="button" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 bg-red-500 hover:bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center transition-all duration-200" onclick="this.parentElement.remove()">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    `;
                    imagePreviewArea.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });
        imageInput.files = dt.files;
    });
    // Auto-save functionality
    let autoSaveTimer;
    contentInput.addEventListener('input', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(autoSave, 30000);
    });

    function autoSave() {
        const formData = new FormData();
        formData.append('content', contentInput.value);
        formData.append('title', titleInput.value);
        formData.append('date', dateInput.value);
        formData.append('mood', moodSelect.value);

        fetch('<?php echo APP_URL ?? ""; ?>/api/autosave', {
            method: 'POST',
            body: formData
        }).then(response => response.json())
        .then(data => {
            if (data.success && typeof showToast === 'function') {
                showToast('Auto-saved', 'success');
            }
        }).catch(e => console.log('Autosave failed:', e));
    }
});
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>