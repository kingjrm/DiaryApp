<?php
$title = 'Edit Entry';
include __DIR__ . '/../components/header.php';
include __DIR__ . '/../components/navbar.php';
?>

<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="glass rounded-xl p-8 neumorphism">
        <h1 class="text-2xl font-bold text-gray-900 mb-8">Edit Diary Entry</h1>

        <form id="diary-form" action="<?php echo APP_URL; ?>/diary/edit/<?php echo $entry['id']; ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-xs font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($entry['title']); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset">
                </div>
                <div>
                    <label for="date" class="block text-xs font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" id="date" name="date" value="<?php echo $entry['entry_date']; ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset">
                </div>
            </div>

            <div>
                <label for="mood" class="block text-xs font-medium text-gray-700 mb-2">Mood (Optional)</label>
                <select id="mood" name="mood" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset">
                    <option value="">Select mood</option>
                    <option value="Happy" <?php echo $entry['mood'] === 'Happy' ? 'selected' : ''; ?>>😊 Happy</option>
                    <option value="Sad" <?php echo $entry['mood'] === 'Sad' ? 'selected' : ''; ?>>😢 Sad</option>
                    <option value="Excited" <?php echo $entry['mood'] === 'Excited' ? 'selected' : ''; ?>>🤩 Excited</option>
                    <option value="Angry" <?php echo $entry['mood'] === 'Angry' ? 'selected' : ''; ?>>😠 Angry</option>
                    <option value="Calm" <?php echo $entry['mood'] === 'Calm' ? 'selected' : ''; ?>>😌 Calm</option>
                    <option value="Anxious" <?php echo $entry['mood'] === 'Anxious' ? 'selected' : ''; ?>>😰 Anxious</option>
                    <option value="Grateful" <?php echo $entry['mood'] === 'Grateful' ? 'selected' : ''; ?>>🙏 Grateful</option>
                    <option value="Tired" <?php echo $entry['mood'] === 'Tired' ? 'selected' : ''; ?>>😴 Tired</option>
                    <option value="Confused" <?php echo $entry['mood'] === 'Confused' ? 'selected' : ''; ?>>😕 Confused</option>
                </select>
            </div>

            <div>
                <label for="content" class="block text-xs font-medium text-gray-700 mb-2">Content</label>
                <textarea id="content" name="content" rows="10" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset resize-none"><?php echo htmlspecialchars($entry['content']); ?></textarea>
            </div>

            <?php if (!empty($images)): ?>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-2">Current Images</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <?php foreach ($images as $image): ?>
                            <div class="relative group">
                                <img src="<?php echo APP_URL; ?>/<?php echo $image['thumbnail_path']; ?>" class="w-full h-24 object-cover rounded-lg">
                                <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity" onclick="deleteImage(<?php echo $image['id']; ?>)">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-2">Add More Images (Optional)</label>
                <div id="image-upload" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-400 transition-colors cursor-pointer neumorphism-inset">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600">Drag & drop images here or click to browse</p>
                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                </div>
                <div id="image-preview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="<?php echo APP_URL; ?>/diary" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors flex items-center">
                    <i class="fas fa-save mr-2"></i>Update Entry
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function deleteImage(imageId) {
    if (confirm('Are you sure you want to delete this image?')) {
        fetch('<?php echo APP_URL; ?>/api/delete-image', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ image_id: imageId, diary_id: <?php echo $entry['id']; ?> })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                showToast('Failed to delete image', 'error');
            }
        });
    }
}

// Include the same JS as create.php for image handling
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>